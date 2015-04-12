<?php
namespace Otc\CoreBundle\Twig;

use Kyoya\DateTime\DateTimeFormatter;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DateFormatExtension extends \Twig_Extension
{

    /**
     * @var DateTimeFormatter
     */
    private static $formatter;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('formatDate', array($this, 'formatDate')),
        );
    }

    /**
     * @param \DateTimeInterface $dateTime
     * @param mixed              $desiredFormat
     *
     * @return string
     */
    public function formatDate(\DateTimeInterface $dateTime, $desiredFormat = null)
    {
        $formatter = $this->getFormatter();

        if (
            null === $desiredFormat ||
            (is_array($desiredFormat) && !isset($desiredFormat['date'], $desiredFormat['time']))
        ) {
            return $formatter->format($dateTime);
        }

        if (is_string($desiredFormat)) {

            return $formatter->formatDateTime($dateTime, $desiredFormat, $desiredFormat);
        }

        $dateFormat = isset($desiredFormat['date']) ? $desiredFormat['date'] : null;
        $timeFormat = isset($desiredFormat['time']) ? $desiredFormat['time'] : null;

        return $formatter->formatDateTime($dateTime, $dateFormat, $timeFormat);
    }

    /**
     * @return DateTimeFormatter
     */
    private function getFormatter()
    {
        if (null === self::$formatter) {
            $request         = $this->container->get('request');
            self::$formatter = new DateTimeFormatter($request->getLocale());
        }

        return self::$formatter;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'otc_core_datetime_format_extension';
    }
}
