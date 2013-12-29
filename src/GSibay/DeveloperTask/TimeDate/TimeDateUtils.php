<?php

namespace GSibay\DeveloperTask\TimeDate;

use \DateTime as DateTime;

/**
 * Time and date utility functions
 * @author gsibay
 *
 */
class TimeDateUtils
{
    /**
     * 
     * Generates an array of date times, starting with $from
     * and adding the $offset until the $to date time is reached.
     * $from is always included unless $from is less than $to.
     * 
     * @param \DateTime $from Starting date.
     * @param string $offset The offset to add succesively to the starting date in 
     * in DateTime Relative format (for instance '+1 day', 'next sunday')
     * @param \DateTime $to End date.
     * @return \DateTime[]
     */
    public function generateTimeDates(\DateTime $from, $offset, \DateTime $to)
    {
        if($from > $to) {
            return array();
        }
        
        $result = array();
        $current = clone $from;
        while($current <= $to) {
            $result[] = clone $current;
            $current->modify($offset);
        }
        return $result;
    }

}