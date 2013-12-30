<?php

namespace GSibay\DeveloperTask\Service;

use GSibay\DeveloperTask\DateTime\DateTimeUtils;
use GSibay\DeveloperTask\Service\DateTimeGeneratorService;
use \DateTime as DateTime;

/**
 * Default implementation of a DateTimeGeneratorService
 *
 * @author gsibay
 *
 */
class DefaultDateTimeGeneratorService implements DateTimeGeneratorService
{
    /**
     * Helper.
     * @var GSibay\DeveloperTask\DateTime\DateTimeUtils
     */
    private $dateTimeUtils;

    /**
     * Date 30 06 1970 13:00:00 GMT
     * @var \DateTime
     */
    private $date30_6_1970_1PMGMT;

    /**
     * Constructor.
     * @param GSibay\DeveloperTask\DateTime\DateTimeUtils $dateTimeUtils.
     */
    public function __construct($dateTimeUtils)
    {
        $this->dateTimeUtils = $dateTimeUtils;
    }

    /**
     * @return GSibay\DeveloperTask\DateTime\DateTimeUtils
     */
    private function getDateTimeUtils()
    {
        return $this->dateTimeUtils;
    }

    private function getDate30_6_1970_1PMGMT()
    {
        if ($this->date30_6_1970_1PMGMT == null) {
            $unixEpoch_1PM_GMT = $this->getDateTimeUtils()->getUnixEpoch1PMGMT();
            $this->date30_6_1970_1PMGMT =
                \DateTime::createFromFormat('U', $unixEpoch_1PM_GMT->modify('+29 day +5 month')->getTimestamp());
        }

        return $this->date30_6_1970_1PMGMT;
    }

    /**
     * (non-PHPdoc)
     * @see GSibay\DeveloperTask\Service.DateTimeGeneratorService::generateDateTimesFromEpoch()
     */
    public function generateDateTimesFromEpoch(\DateTime $until)
    {
        return $this->dateTimeUtils->generateDateTimes($this->getDate30_6_1970_1PMGMT(),
                 '+1 year', $until);
    }
}
