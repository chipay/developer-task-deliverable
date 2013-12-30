<?php

namespace GSibay\DeveloperTask\Service;

use \DateTime as DateTime;

/**
 * Generates every 30th of June since the Unix Epoch, at 1pm GMT,
 *
 * @author gsibay
 *
 */
interface DateTimeGeneratorService
{

    /**
     * Generates one entry per year starting at 30 6 1970 13:00:00 GMT until (inclusive) the
     * date $until.
     * For example if until is 30 6 1971 13:00:00 GMT this service will return
     * an array with two dates: 30 6 1970 13:00:00 GMT and 30 6 1971 13:00:00 GMT 
     *  
     * @param \DateTime $until
     * @return \DateTime[]
     */
    public function generateDateTimesFromEpoch(\DateTime $until);
}