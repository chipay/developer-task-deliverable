<?php

namespace GSibay\DeveloperTask\Tests\Predicate;

use GSibay\DeveloperTask\Predicate\IsYearCompositeNumber;
use \DateTime as DateTime;
use \DateTimeZone as DateTimeZone;

class IsYearCompositeNumberTest extends \PHPUnit_Framework_TestCase
{

    private $predicate;

    public function setup()
    {
        parent::setup();
        $this->predicate = new IsYearCompositeNumber();
    }

    public function testEvalute_CompositeYearGMTTimeZone_ReturnsTrue()
    {
        $format = 'd-m-Y';
        $date = DateTime::createFromFormat($format, '20-10-1940', new DateTimeZone('GMT'));
        $this->assertTrue($this->predicate->evaluate($date));
    }

    public function testEvalute_PrimeYearGMTTimeZone_ReturnsFalse()
    {
        $format = 'd-m-Y';
        $date = DateTime::createFromFormat($format, '20-10-1973', new DateTimeZone('GMT'));
        $this->assertFalse($this->predicate->evaluate($date));
    }

    public function testEvalute_CompositeYearPSTTimeZone_ReturnsTrue()
    {
        $format = 'd-m-Y';
        $date = DateTime::createFromFormat($format, '21-01-2005', new DateTimeZone('PST'));
        $this->assertTrue($this->predicate->evaluate($date));
    }

    public function testEvalute_PrimeYearPSTTimeZone_ReturnsFalse()
    {
        $format = 'd-m-Y';
        $date = DateTime::createFromFormat($format, '20-10-1987', new DateTimeZone('PST'));
        $this->assertFalse($this->predicate->evaluate($date));
    }

    public function testEvalute_Year0_RetrurnsTrue()
    {
        $format = 'd-m-Y';
        $date = DateTime::createFromFormat($format, '20-10-0', new DateTimeZone('GMT'));
        $this->assertTrue($this->predicate->evaluate($date));
    }

    /**
     * @expectedException        \UnexpectedValueException
     */
    public function testEvalute_YearGreaterThan2203_ThrowsException()
    {
        $format = 'd-m-Y';
        $date = DateTime::createFromFormat($format, '20-10-2205', new DateTimeZone('GMT'));
        $this->assertTrue($this->predicate->evaluate($date));
    }

    /**
     * @expectedException        \UnexpectedValueException
     */
    public function testEvalute_YearBC_ThrowsException()
    {
        $date = DateTime::createFromFormat('d-m-Y', '23-10-01');
        $date->modify("-40 year");

        $this->assertTrue($this->predicate->evaluate($date));
    }
}
