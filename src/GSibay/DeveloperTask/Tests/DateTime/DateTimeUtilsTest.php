<?php

namespace GSibay\DeveloperTask\Tests\DateTime;

use GSibay\DeveloperTask\DateTime\DateTimeUtils;

use \DateTime as DateTime;
use \DateTimeZone as DateTimeZone;

class TimeDateUtilsTest extends \PHPUnit_Framework_TestCase
{

    public function testGetUnixEpopch1PMGMT_TimestampEqualsConstant()
    {
        $utils = new DateTimeUtils();
        $this->assertEquals($utils->getUnixEpoch1PMGMT()->getTimestamp(), DateTimeUtils::UNIX_EPOCH_1PM_GMT);
    }

    public function testGetDateTimeZoneGMT_IsDateTimeZoneGMT()
    {
        $utils = new DateTimeUtils();
        $dateTimeZoneGMT = new DateTimeZone('GMT'); 
        $this->assertEquals($utils->getdateTimeZoneGMT(), $dateTimeZoneGMT);
    }
    
    public function testGetDateTimeZonePST_IsDateTimeZonePST()
    {
        $utils = new DateTimeUtils();
        $dateTimeZonePST = new DateTimeZone('PST');
        $this->assertEquals($utils->getdateTimeZonePST(), $dateTimeZonePST);
    }
    
    public function testTimeDateZoneGMT_TwoCalls_GetsSameObject()
    {
        $utils = new DateTimeUtils();
        $dateTimeZoneGMT = $utils->getdateTimeZoneGMT();
        $this->assertTrue($dateTimeZoneGMT === $utils->getdateTimeZoneGMT());
    }
    
    public function testGetTimeDateZonePST_TwoCalls_GetsSameObject()
    {
        $utils = new DateTimeUtils();
        $dateTimeZonePST = $utils->getdateTimeZonePST();
        $this->assertTrue($dateTimeZonePST === $utils->getdateTimeZonePST());
    }
    
    public function testGetUnixEpoch1PMGMT_TwoCalls_GetsSameObject()
    {
        $utils = new DateTimeUtils();
        $unixEpoch1PMGMT = $utils->getUnixEpoch1PMGMT();
        $this->assertTrue($unixEpoch1PMGMT === $utils->getUnixEpoch1PMGMT());
    }
    
    public function testGenerateDates_NegativeInterval_ReturnEmptyArray()
    {
        $utils = new DateTimeUtils();
        $dates = $utils->generateDateTimes(new DateTime(), "+1 day", new DateTime('yesterday'));
        $this->assertEmpty($dates);
    }
    
    public function testGenerateDates_SameDates_ReturnTheDate()
    {
        $utils = new DateTimeUtils();
        $date = new DateTime();
        $dates = $utils->generateDateTimes($date, "+1 year", $date);
        $this->assertEquals($dates, array($date));
    }
    
    public function testGenerateDates_PositiveInterval_ReturnFourDates()
    {
        $utils = new DateTimeUtils();
        $from = new DateTime("20-1-1990");
        $to = new DateTime("23-1-1990");
        $dates = $utils->generateDateTimes($from, "next day", $to);
        $this->assertEquals($dates, array($from, new DateTime('21-1-1990'), new DateTime('22-1-1990') ,$to));
    }
    
    public function testGenerateDates_SameDateEveryYear()
    {
        $utils = new DateTimeUtils();
        $from = new DateTime('30-8-1970');
        $to = new DateTime('30-8-1981');
        $dates = $utils->generateDateTimes($from, "+1 year", $to);
        $this->assertEquals($dates, array($from, new DateTime('30-8-1971'), new DateTime('30-8-1972') ,
                new DateTime('30-8-1973'), new DateTime('30-8-1974'), new DateTime('30-8-1975'),
                new DateTime('30-8-1976'), new DateTime('30-8-1977'), new DateTime('30-8-1978'),
                new DateTime('30-8-1979'), new DateTime('30-8-1980'), $to));
    }
}