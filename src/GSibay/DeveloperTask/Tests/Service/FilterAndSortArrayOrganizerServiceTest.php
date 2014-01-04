<?php

namespace GSibay\DeveloperTask\Tests\Service;

use GSibay\DeveloperTask\Comparator\Comparator;
use GSibay\DeveloperTask\Predicate\Predicate;
use GSibay\DeveloperTask\Service\FilterAndSortArrayOrganizerService;
use GSibay\DeveloperTask\Comparator\NaturalOrderComparator;

use \DateTime as DateTime;
use \DateTimeZone as DateTimeZone;
use \Mockery as M;

class FilterAndSortArrayOrganiserServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
    public function setUp()
    {
        parent::setUp();
        $this->service = new FilterAndSortArrayOrganizerService();
    }*/

    private $arrayOrganizer;

    private function createService(Predicate $predicate = null, Comparator $comparator = null)
    {
        return new FilterAndSortArrayOrganizerService($predicate, $comparator);
    }

    /**
     * Gets a mocked comparator with the natural comparison
     * @return callback
     */
    private function getNaturalComparator()
    {
        //XXX: mock comparator can not be used because usort (used by the service under test) throws a warning that makes th
        // test fail. An order had to be provided in the mock object anyway. However this is not ideal.
        return new NaturalOrderComparator();
    }

    /**
    public function setup()
    {
        parent::setup();
        $this->arrayOrganizer = new ArrayOrganizer();
    }*/

    public function test_Organize_NoFilterAndNoComparatorOnEmptyArray_ReturnsEmptyArray()
    {
        $toBeOrganized = array();
        $this->assertEquals(array(), $this->createService()->organize($toBeOrganized));
    }

    public function test_Organize_FilterAndNoComparatorOnEmptyArray_ReturnsEmptyArray()
    {
        $filter = M::mock('GSibay\DeveloperTask\Predicate\Predicate');

        $toBeOrganized = array();

        $this->assertEquals(array(), $this->createService($filter)->organize($toBeOrganized));
    }

    public function test_Organize_FilterAndComparatorOnEmptyArray_ReturnsEmptyArray()
    {
        $filter = M::mock('GSibay\DeveloperTask\Predicate\Predicate');
        $comparator = M::mock('GSibay\DeveloperTask\Comparator\Comparator');

        $toBeOrganized = array();
        $this->assertEquals(array(), $this->createService($filter, $comparator)->organize($toBeOrganized));
    }

    public function test_Organize_FilterAndNoComparatorOnThreeNumberElements_AppliesFilterOnArray()
    {
        $toBeOrganized = array(24, 35, 17);

        $filter = M::mock('GSibay\DeveloperTask\Predicate\Predicate');
        $filter->shouldReceive('evaluate')->with('24')->once()->ordered()->andReturn(false);
        $filter->shouldReceive('evaluate')->with('35')->once()->ordered()->andReturn(true);
        $filter->shouldReceive('evaluate')->with('17')->once()->andReturn(false)->ordered();

        $expectedObject = array(35);

        // use array_values on the returned array to reset the keys and compare to the expected object
        $this->assertEquals($expectedObject, array_values($this->createService($filter)->organize($toBeOrganized)));
    }

    public function test_Organize_NoFilterAndComparatorOnThreeNumberElements_ReturnsSortedOnArray()
    {
        //$this->test_incomplete();
        $toBeOrganized = array(24, 35, 17);

        $comparator = $this->getNaturalComparator();

        $expectedObject = array(17, 24, 35);

        // use array_values on the returned array to reset the keys and compare to the expected object
        $this->assertEquals($expectedObject, array_values($this->createService(null, $comparator)->organize($toBeOrganized)));
    }

    public function test_Organize_NoFilterAndComparatorOnFourDateTimeElements_ReturnsSortedArray()
    {
        $date1 = DateTime::createFromFormat('d-m-Y', '11-08-2001', new DateTimeZone('PST'));
        $date2 = DateTime::createFromFormat('d-m-Y', '11-08-2000', new DateTimeZone('GMT'));
        $date3 = DateTime::createFromFormat('d-m-Y', '8-9-1976', new DateTimeZone('America/Argentina/Ushuaia'));
        $date4 = DateTime::createFromFormat('d-m-Y', '8-9-1979', new DateTimeZone('America/Argentina/Ushuaia'));

        $toBeOrganized = array($date1, $date2, $date3, $date4);

        $comparator = $this->getNaturalComparator();

        $expectedObject = array($date3, $date4, $date2, $date1);

        // use array_values on the returned array to reset the keys and compare to the expected object
        $this->assertEquals($expectedObject, array_values($this->createService(null, $comparator)->organize($toBeOrganized)));
    }

    public function test_Organize_FilterAndNoComparatorOnFiveDateTimeElements_ReturnsFilteredAndSortedArray()
    {
        $date1 = DateTime::createFromFormat('d-m-Y', '11-08-2001', new DateTimeZone('PST'));
        $date2 = DateTime::createFromFormat('d-m-Y', '11-08-2000', new DateTimeZone('GMT'));
        $date3 = DateTime::createFromFormat('d-m-Y', '8-9-1976', new DateTimeZone('America/Argentina/Ushuaia'));
        $date4 = DateTime::createFromFormat('d-m-Y', '1-1-2010', new DateTimeZone('America/Argentina/Ushuaia'));
        $date5 = DateTime::createFromFormat('d-m-Y', '8-9-1975', new DateTimeZone('PST'));

        $toBeOrganized = array($date1, $date2, $date3, $date4, $date5);

        $filter = M::mock('GSibay\DeveloperTask\Predicate\Predicate');
        $filter->shouldReceive('evaluate')->with($date1)->once()->ordered()->andReturn(false);
        $filter->shouldReceive('evaluate')->with($date2)->once()->ordered()->andReturn(true);
        $filter->shouldReceive('evaluate')->with($date3)->once()->ordered()->andReturn(true);
        $filter->shouldReceive('evaluate')->with($date4)->once()->ordered()->andReturn(false);
        $filter->shouldReceive('evaluate')->with($date5)->once()->ordered()->andReturn(true);

        $comparator = $this->getNaturalComparator();

        $expectedObject = array($date5, $date3, $date2);

        // use array_values on the returned array to reset the keys and compare to the expected object
        $this->assertEquals($expectedObject, array_values($this->createService($filter, $comparator)->organize($toBeOrganized)));
    }
}
