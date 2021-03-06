<?php
/**
 * This file is part of oTranCe released under the GNU/GPL 2 license
 * http://www.otrance.org
 *
 * @package         OTranCe
 * @version         SVN: $Rev$
 * @author          $Author$
 */
/**
 * Bootstrap class
 *
 * @package oTranCe
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Initialize action helpers.
     *
     * @return void
     */
    public function _initActionHelpers()
    {
        Zend_Controller_Action_HelperBroker::addHelper(
            new Msd_Action_Helper_AssignConfigAndLanguage()
        );
    }

    /**
     * Start session
     *
     * Anything else is set in configs/application.ini
     *
     * @return void
     */
    public function _initApplication()
    {
        Zend_Session::setOptions(array('strict' => true));
        Zend_Session::start();

        $moduleLoader = new Msd_Module_Loader(array('Module_' => realpath(APPLICATION_PATH . '/../modules/library/')));
        Zend_Loader_Autoloader::getInstance()->pushAutoloader($moduleLoader, 'Module_');

        // include main controller without adding another path to autoloader
        include_once(APPLICATION_PATH . '/controllers/OtranceController.php');

        // check if server has magic quotes enabled and normalize params
        if ((function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc() == 1)) {
            $_POST = Bootstrap::stripslashes_deep($_POST);
        }
    }

    /**
     * Initialize configuration.
     *
     * @return void
     */
    public function _initConfiguration()
    {
        $dynamicConfig = new Msd_Config_Dynamic();
        $configFile    = $dynamicConfig->getParam('configFile', 'config.ini');
        $config        = new Msd_Config(
            'Default',
            array('directories' => APPLICATION_PATH . DIRECTORY_SEPARATOR . 'configs')
        );
        $config->load($configFile);
        Msd_Registry::setConfig($config);

        Msd_Registry::setDynamicConfig($dynamicConfig);
    }

    /**
     * Init plug ins
     *
     * @return void
     */
    public function _initPlugIns()
    {
        $frontController = Zend_Controller_Front::getInstance();
        $frontController->registerPlugin(new Application_Plugin_FileTemplateCheck());
    }

    /**
     * Un-quote a string or array
     *
     * @param string|array $value The value to strip
     *
     * @return string|array
     */
    public static function stripslashes_deep($value)
    {
        $value = is_array($value) ? array_map('Bootstrap::stripslashes_deep', $value) : stripslashes($value);

        return $value;
    }

    /**
     * Set cli router if app is called via cli
     *
     * @return void
     */
    protected function _initRouter()
    {
        if (PHP_SAPI == 'cli' && APPLICATION_ENV !== 'testing') {
            $this->bootstrap('FrontController');
            $front = $this->getResource('FrontController');
            $front->setParam('disableOutputBuffering', true);
            $front->registerPlugin(new Application_Plugin_DisableLayout());
            include_once(dirname(__FILE__) . '/router/Cli.php');
            $front->setRouter(new Application_Router_Cli());
        }
    }
}
