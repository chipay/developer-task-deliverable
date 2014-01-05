<?php

namespace GSibay\DeveloperTask\Tests\Comparator;

use GSibay\DeveloperTask\Comparator\NaturalOrderComparator;
use \DateTime as DateTime;
use \DateTimeZone as DateTimeZone;

class NaturalOrderComparatorTest extends \PHPUnit_Framework_TestCase
{

    private $ascendingComparator;
    private $descendingComparator;

    public function setup()
    {
        parent::setup();
        $this->ascendingComparator = new NaturalOrderComparator();
        $this->descendingComparator = new NaturalOrderComparator(false);
    }

    public function testCompareAscending_SameObjects_Returns0()
    {
        $this->assertEquals(0, $this->ascendingComparator->compareTo(4, 4));
        $date1 = new DateTime();
        $this->assertEquals(0, $this->ascendingComparator->compareTo($date1, $date1));
    }

    public function testCompareDescending_SameObjects_Returns0()
    {
        $this->assertEquals(0, $this->descendingComparator->compareTo(8, 8));
        $date = new DateTime();
        $this->assertEquals(0, $this->descendingComparator->compareTo($date, $date));
    }

    public function testCompareAscescending_EqualObjects_Returns0()
    {
        $this->assertEquals(0, $this->ascendingComparator->compareTo(4, 4));
        $date1 = new DateTime();
        $date2 = clone $date1;
        $this->assertEquals(0, $this->ascendingComparator->compareTo($date1, $date2));
    }

    public function testCompareDescescending_EqualObjects_Returns0()
    {
        $this->assertEquals(0, $this->descendingComparator->compareTo(4, 4));
        $date1 = new DateTime();
        $date2 = clone $date1;
        $this->assertEquals(0, $this->descendingComparator->compareTo($date1, $date2));
    }

    public function testCompareAscending_FirstBiggerThanSecond_ReturnsPositive()
    {
        $this->assertTrue($this->ascendingComparator->compareTo(5, 4) > 0);
        $this->assertTrue($this->ascendingComparator->compareTo(24, 12) > 0);
        $this->assertTrue($this->ascendingComparator->compareTo(33, -198) > 0);

        $this->assertTrue($this->ascendingComparator->compareTo(
                \DateTime::createFromFormat('d-m-Y', '21-10-1980', new DateTimeZone('GMT')),
                \DateTime::createFromFormat('d-m-Y', '11-09-1970', new DateTimeZone('GMT'))) > 0);

        $this->assertTrue($this->ascendingComparator->compareTo(
                \DateTime::createFromFormat('d-m-Y', '1-1-1980', new DateTimeZone('GMT')),
                \DateTime::createFromFormat('d-m-Y', '31-12-1979', new DateTimeZone('GMT'))) > 0);
    }

    public function testCompareDescending_FirstBiggerThanSecond_ReturnsNegative()
    {
        $this->assertTrue($this->descendingComparator->compareTo(23, 7) < 0);
        $this->assertTrue($this->descendingComparator->compareTo(12345, 0) < 0);
        $this->assertTrue($this->descendingComparator->compareTo(12, -12) < 0);

        $this->assertTrue($this->descendingComparator->compareTo(
                \DateTime::createFromFormat('d-m-Y', '11-09-2020', new DateTimeZone('GMT')),
                \DateTime::createFromFormat('d-m-Y', '11-11-2001', new DateTimeZone('GMT'))) < 0);

        $this->assertTrue($this->descendingComparator->compareTo(
                \DateTime::createFromFormat('d-m-Y', '31-12-2000', new DateTimeZone('GMT')),
                \DateTime::createFromFormat('d-m-Y', '1-1-1986', new DateTimeZone('GMT'))) < 0);
    }

    public function testCompareAscending_FirstSmallerThanSecond_ReturnsNegative()
    {
        $this->assertTrue($this->ascendingComparator->compareTo(2, 4) < 0);
        $this->assertTrue($this->ascendingComparator->compareTo(0, 1796) < 0);
        $this->assertTrue($this->ascendingComparator->compareTo(-55, 28997) < 0);

        $this->assertTrue($this->ascendingComparator->compareTo(
                \DateTime::createFromFormat('d-m-Y', '01-01-1980', new DateTimeZone('GMT')),
                \DateTime::createFromFormat('d-m-Y', '01-01-1981', new DateTimeZone('GMT'))) < 0);

        $this->assertTrue($this->ascendingComparator->compareTo(
                \DateTime::createFromFormat('d-m-Y', '1-1-1980', new DateTimeZone('GMT')),
                \DateTime::createFromFormat('d-m-Y', '31-12-1989', new DateTimeZone('GMT'))) < 0);

    }

    public function testCompareDescending_FirstSmallerThanSecond_ReturnsPositive()
    {
        $this->assertTrue($this->descendingComparator->compareTo(2, 4) > 0);
        $this->assertTrue($this->descendingComparator->compareTo(0, 1796) > 0);
        $this->assertTrue($this->descendingComparator->compareTo(-55, 28997) > 0);

        $this->assertTrue($this->descendingComparator->compareTo(
                \DateTime::createFromFormat('d-m-Y', '12-12-2000', new DateTimeZone('GMT')),
                \DateTime::createFromFormat('d-m-Y', '01-01-2010', new DateTimeZone('GMT'))) > 0);

        $this->assertTrue($this->descendingComparator->compareTo(
                \DateTime::createFromFormat('d-m-Y', '1-1-1985', new DateTimeZone('GMT')),
                \DateTime::createFromFormat('d-m-Y', '31-12-1999', new DateTimeZone('GMT'))) > 0);
    }

}
