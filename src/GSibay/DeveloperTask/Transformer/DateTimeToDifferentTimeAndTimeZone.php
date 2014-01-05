<?php

namespace GSibay\DeveloperTask\Transformer;

use \DateTimeZone as DateTimeZone;

/**
 * Converts the date into the desired TimeZone and then
 * changes the time to the provided hour, minutes, and seconds.
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
    public function transform($date)
    {
        $transformedDate = clone $date;
        $transformedDate->setTimezone($this->timezone);
        $transformedDate->setTime($this->hour, $this->minutes, $this->seconds);

        return $transformedDate;
    }

}
