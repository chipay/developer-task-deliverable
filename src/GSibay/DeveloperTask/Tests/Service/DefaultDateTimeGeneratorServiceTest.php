<?php

namespace GSibay\DeveloperTask\Tests\Service;

use GSibay\DeveloperTask\DateTime\DateTimeUtils;
use GSibay\DeveloperTask\Service\DefaultDateTimeGeneratorService;
use GSibay\DeveloperTask\Service\DateTimeGeneratorService;
use \DateTimeZone as DateTimeZone;

class DefaultDateTimeGeneratorServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The datetime generator service
     * @var GSibay\DeveloperTask\Service\DateTimeGeneratorService
     */
    private $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = new DefaultDateTimeGeneratorService(new DateTimeUtils());
    }

    /**
     *
     * @param \DateTime $until
     */
    public function generateDateTimes(\DateTime $until)
    {
        return $this->service->generateDateTimesFromEpoch($until);
    }

    public function testGenerateDateTimesFromEpoch_UntilBeforeEpoch_ReturnEmptyArray()
    {
        $date23_12_52 = \DateTime::createFromFormat('d-m-Y', '23-10-1952');
        $this->assertEquals($this->generateDateTimes($date23_12_52), array());
    }

    public function testGenerateDateTimesFromEpoch_UntilAlmost30_6_1970_1PMGMT_ReturnEmptyArray()
    {
        $dateAlmost30_6_71_1PM_GMT = \DateTime::createFromFormat('U', gmmktime(12, 59, 59, 6, 30, 1970));
        $this->assertEquals(array(), $this->generateDateTimes($dateAlmost30_6_71_1PM_GMT));

    }

    public function testGenerateDateTimesFromEpoch_Until30_6_1970_1PMGMT_ReturnOneDate()
    {
        $date30_6_70_1PM_GMT = \DateTime::createFromFormat('U', gmmktime(13, 0, 0, 6, 30, 1970));
        $expected = array($date30_6_70_1PM_GMT);
        $this->assertEquals($expected, $this->generateDateTimes($date30_6_70_1PM_GMT));
    }

    public function testGenerateDateTimesFromEpoch_Until30_6_1971_1PMGMT_ReturnTwoDates()
    {
        $date30_6_71_1PM_GMT = \DateTime::createFromFormat('U', gmmktime(13, 0, 0, 6, 30, 1971));
        $date30_6_70_1PM_GMT = \DateTime::createFromFormat('U', gmmktime(13, 0, 0, 6, 30, 1970));

        $expected = array($date30_6_70_1PM_GMT, $date30_6_71_1PM_GMT);
        $this->assertEquals($expected, $this->generateDateTimes($date30_6_71_1PM_GMT));
    }

    public function testGenerateDateTimesFromEpoch_Until20_1_1973_6PMGMT_UseOtherTimezone_ReturnThreeDates()
    {
        $date30_6_71_1PM_GMT = \DateTime::createFromFormat('U', gmmktime(13, 0, 0, 6, 30, 1971));
        $date30_6_70_1PM_GMT = \DateTime::createFromFormat('U', gmmktime(13, 0, 0, 6, 30, 1970));
        $date30_6_72_1PM_GMT = \DateTime::createFromFormat('U', gmmktime(13, 0, 0, 6, 30, 1972));

        $until = \DateTime::createFromFormat('U', gmmktime(18, 0, 0, 1, 20, 1973));
        $until->setTimeZone(new DateTimeZone('PST'));

        $expected = array($date30_6_70_1PM_GMT, $date30_6_71_1PM_GMT, $date30_6_72_1PM_GMT);
        $this->assertEquals($expected, $this->generateDateTimes($until));
    }
}
