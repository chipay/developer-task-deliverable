<?php

namespace GSibay\DeveloperTask\Tests\TimeDate;

use GSibay\DeveloperTask\TimeDate\TimeDateUtils;

use \DateTime as DateTime;
use \DateTimeZone as DateTimeZone;

class TimeDateUtilsTest extends \PHPUnit_Framework_TestCase
{

    public function testGenerateDates_NegativeInterval_ReturnEmptyArray()
    {
        $utils = new TimeDateUtils();
        $dates = $utils->generateTimeDates(new DateTime(), "+1 day", new DateTime('yesterday'));
        $this->assertEmpty($dates);
    }
    
    public function testGenerateDates_SameDates_ReturnTheDate()
    {
        $utils = new TimeDateUtils();
        $date = new DateTime();
        $dates = $utils->generateTimeDates($date, "+1 year", $date);
        $this->assertEquals($dates, array($date));
    }
    
    public function testGenerateDates_PositiveInterval_ReturnFourDates()
    {
        $utils = new TimeDateUtils();
        $from = new DateTime("20-1-1990");
        $to = new DateTime("23-1-1990");
        $dates = $utils->generateTimeDates($from, "next day", $to);
        $this->assertEquals($dates, array($from, new DateTime('21-1-1990'), new DateTime('22-1-1990') ,$to));
    }
    
    public function testGenerateDates_SameDateEveryYear()
    {
        $utils = new TimeDateUtils();
        $from = new DateTime('30-8-1970');
        $to = new DateTime('30-8-1981');
        $dates = $utils->generateTimeDates($from, "+1 year", $to);
        $this->assertEquals($dates, array($from, new DateTime('30-8-1971'), new DateTime('30-8-1972') ,
                new DateTime('30-8-1973'), new DateTime('30-8-1974'), new DateTime('30-8-1975'),
                new DateTime('30-8-1976'), new DateTime('30-8-1977'), new DateTime('30-8-1978'),
                new DateTime('30-8-1979'), new DateTime('30-8-1980'), $to));
    }
}