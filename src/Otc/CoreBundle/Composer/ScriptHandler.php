<?php

namespace Otc\CoreBundle\Composer;

use Composer\DependencyResolver\Operation\UpdateOperation;
use Composer\Installer\PackageEvent;
use Composer\DependencyResolver\Operation\UninstallOperation;
use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\IO\IOInterface;
use Composer\Script\Event;

class ScriptHandler
{

    private static $bundleClasses = array(
        'add'    => array(),
        'remove' => array(),
    );

    /**
     * @var IOInterface
     */
    private static $io;

    public static function postInstallPackage(PackageEvent $event)
    {
        $operation = $event->getOperation();
        if ($operation instanceof UninstallOperation) {
            $package = $operation->getPackage();
        } else if ($operation instanceof UpdateOperation) {
            $package = $operation->getTargetPackage();
        }

        if ('symfony-bundle' != $package->getType()) {
            return;
        }

        try {
            $installPath = $event->getComposer()->getInstallationManager()->getInstallPath($package);
            $bundleClass = self::getBundleClass($installPath);

            self::$bundleClasses['add'][$package->getName()] = $bundleClass;
        } catch (\Exception $ignored) {
        }
    }

    public static function preUninstallPackage(PackageEvent $event)
    {
        $operation = $event->getOperation();
        if ($operation instanceof UninstallOperation) {
            $package = $operation->getPackage();
        } else if ($operation instanceof UpdateOperation) {
            $package = $operation->getTargetPackage();
        }

        if ('symfony-bundle' != $package->getType()) {
            return;
        }

        try {
            $installPath = $event->getComposer()->getInstallationManager()->getInstallPath($package);
            $bundleClass = self::getBundleClass($installPath);

            self::$bundleClasses['remove'][$package->getName()] = $bundleClass;
        } catch (\Exception $ignored) {
        }
    }

    private static function getBundleClass($installPath)
    {
        $bundleFiles = glob("{$installPath}/*Bundle.php");
        if (0 == count($bundleFiles)) {
            throw new \Exception("No bundle file!");
        }

        $bundleClassFile = file_get_contents($bundleFiles[0]);
        if (!preg_match('/class ([a-zA-Z0-9_]+)/', $bundleClassFile, $matches)) {
            throw new \Exception("No bundle class!");
        }

        $bundleClass = $matches[1];

        if (preg_match('/namespace ([a-zA-Z0-9\\\\_]+)/', $bundleClassFile, $matches)) {
            $bundleNamespace = $matches[1];
            $bundleClass     = "{$bundleNamespace}\\{$bundleClass}";
        }

        return $bundleClass;
    }

    public static function postCommand(Event $event)
    {
        self::$io = $event->getIO();

        self::$io->write('<info>Updating AppKernel...</info>', false);
        if (0 == (count(self::$bundleClasses['add']) + count(self::$bundleClasses['remove']))) {
            self::$io->write('<warning>nothing to do.</warning>', true);

            return;
        }

        self::$io->write('');

        $baseDir    = $event->getComposer()->getConfig()->get('vendor-dir') . '/..';
        $kernelFile = $baseDir . '/app/AppKernel.php';

        if (file_exists($kernelFile . '~')) {
            unlink($kernelFile . '~');
        }

        copy($kernelFile, $kernelFile . '~');

        if (0 < count(self::$bundleClasses['remove'])) {
            self::$io->write("<comment>Removing old bundles...", false);

            $kernelClass = self::getTempKernelClass($kernelFile);
            self::removeBundles($kernelFile, $kernelClass);

            self::$io->write("done</comment>");
        }

        if (0 < count(self::$bundleClasses['add'])) {
            self::$io->write("<comment>Adding new bundles...", false);

            $kernelClass = self::getTempKernelClass($kernelFile);

            self::addBundles($kernelFile, $kernelClass);

            self::$io->write("done</comment>");
        }
    }

    private static function addBundles($kernelFile, $kernelClass)
    {
        $lines = file($kernelFile);

        $reflection      = new \ReflectionClass($kernelClass);
        $registerBundles = $reflection->getMethod('registerBundles');
        $oldMethod       = implode(
            '',
            array_slice(
                $lines,
                $registerBundles->getStartLine() - 1,
                $registerBundles->getEndLine() - $registerBundles->getStartLine() + 1
            )
        );

        $newMethod = $oldMethod;

        foreach (self::$bundleClasses['add'] as $bundleClass) {
            if (false !== strpos($newMethod, "new {$bundleClass}(),")) {
                continue;
            }

            $newMethod = (preg_replace('/(\s+)(\);)/', "\\1    new {$bundleClass}(),\\1\\2", $newMethod));
        }

        $newKernel = str_replace($oldMethod, $newMethod, implode('', $lines));

        file_put_contents($kernelFile, $newKernel);
    }

    private static function removeBundles($kernelFile, $kernelClass)
    {
        $lines = file($kernelFile);

        $reflection      = new \ReflectionClass($kernelClass);
        $registerBundles = $reflection->getMethod('registerBundles');
        $oldMethod       = implode(
            '',
            array_slice(
                $lines,
                $registerBundles->getStartLine() - 1,
                $registerBundles->getEndLine() - $registerBundles->getStartLine() + 1
            )
        );

        $newMethod = $oldMethod;

        foreach (self::$bundleClasses['remove'] as $bundleClass) {
            $bundleClass = addslashes($bundleClass);
            $newMethod   = preg_replace("/(\\s+new {$bundleClass}\\(\\),)/", '', $newMethod);
        }

        $newKernel = str_replace($oldMethod, $newMethod, implode('', $lines));

        file_put_contents($kernelFile, $newKernel);
    }

    /**
     * @param $kernelFile
     *
     * @return string
     */
    private static function getTempKernelClass($kernelFile)
    {
        $kernelFileContents = file_get_contents($kernelFile);
        $kernelClass        = 'AppKernel' . md5(microtime());

        $kernel = str_replace('class AppKernel', 'class ' . $kernelClass, $kernelFileContents) . "\n";
        eval(str_replace('<?php', '', $kernel));

        return $kernelClass;
    }
}
