<?php

namespace GSibay\DeveloperTask\DateTime;

use \DateTimeImmutable as DateTimeImmutable;
use \DateTime as DateTime;
use \DateTimeZone as DateTimeZone;

/**
 * Time and date utility functions
 * @author gsibay
 *
 */
class DateTimeUtils
{

    /**
     * Unix epoch at 1PM GMT (Thu, 01 Jan 1970 13:00:00 GMT)
     * @var \DateTime
     */
    private $unixEpoch1PMGMT;

    /**
     * GMT DateTimeZone
     * @var \DateTimeZone
     */
    private $dateTimeZoneGMT;

    /**
     * PST DateTimeZone
     * @var \DateTimeZone
     */
    private $dateTimeZonePST;

    /**
     * Returns Unix epoch at 1PM GMT (Thu, 01 Jan 1970 13:00:00 GMT).
     * Cached value.
     * @return \DateTimeImmutable
     */
    public function getUnixEpoch1PMGMT()
    {
        if ($this->unixEpoch1PMGMT == null) {
            $this->unixEpoch1PMGMT = DateTime::createFromFormat('d-m-Y H:i:s', '01-01-1970 13:00:00', $this->getdateTimeZoneGMT());
        }

        return $this->unixEpoch1PMGMT;
    }

    /**
     * Returns GMT DateTimeZone
     * Cached value.
     * @return \DateTimeZone
     */
    public function getdateTimeZoneGMT()
    {
        if ($this->dateTimeZoneGMT == null) {
            $this->dateTimeZoneGMT = new DateTimeZone('GMT');
        }

        return $this->dateTimeZoneGMT;
    }

    /**
     * Returns PST DateTimeZone
     * Cached value.
     * @return \DateTimeZone
     */
    public function getdateTimeZonePST()
    {
        if ($this->dateTimeZonePST == null) {
            $this->dateTimeZonePST = new DateTimeZone('PST');
        }

        return $this->dateTimeZonePST;
    }

    /**
     *
     * Generates an array of date times, starting with $from
     * and adding the $offset until the $to date time is reached.
     * $from is always included unless $from is less than $to.
     *
     * @param  \DateTime   $from   Starting date.
     * @param  string      $offset The offset to add succesively to the starting date in
     *                             in DateTime Relative format (for instance '+1 day', 'next sunday')
     * @param  \DateTime   $to     End date.
     * @return \DateTime[]
     */
    public function generateDateTimes(\DateTime $from, $offset, \DateTime $to)
    {
        if ($from > $to) {
            return array();
        }

        $result = array();
        $current = clone $from;
        while ($current <= $to) {
            $result[] = clone $current;
            $current->modify($offset);
        }

        return $result;
    }

}
