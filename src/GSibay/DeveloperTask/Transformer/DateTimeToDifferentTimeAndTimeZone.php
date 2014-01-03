<?php

namespace GSibay\DeveloperTask\Transformer;

use \DateTimeZone as DateTimeZone;

/**
 * TODO
 * @author gsibay
 *
 */
class DateTimeToDifferentTimeAndTimeZone extends AbstractTransformer
{

    /**
     * @var \DateTimeZone
     */
    private $timezone;

    /**
     * @var int
     */
    private $hour;

    /**
     * @var int
     */
    private $minutes;

    /**
     * @var int
     */
    private $seconds;

    /**
     *
     * Constructor.
     * @param string $timezoneStr The timezone code identifier
     * @param int    $hour
     * @param int    $minutes
     * @param int    $seconds
     */
    public function __construct($timezoneStr, $hour, $minutes, $seconds)
    {
        $this->hour = $hour;
        $this->minutes = $minutes;
        $this->seconds = $seconds;
        $this->timezone = new DateTimeZone($timezoneStr);
    }

    /**
     * (non-PHPdoc)
     * @see GSibay\DeveloperTask\Transformer.Transformer::transform()
     */
    public function transform($anObject)
    {
        //TODO: code
        return null;

        /**
$newDate->setTimezone($timeZonePST);
var_dump('unix time date 30-6-2009 en PST: ');
var_dump($newDate->format('Y-m-d H:i:s e - U'));
var_dump('offset: '.$newDate->getOffset());

//LISTO, ASI LA MODIFICO
var_dump('modifico para que este a las 13 (en PST)');
$newDate->setTime(13, 0, 0);
         */
    }
}
