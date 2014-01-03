<?php

namespace GSibay\DeveloperTask\Tests\Predicate;

use GSibay\DeveloperTask\Predicate\IsYearCompositeNumber;
use \DateTime as DateTime;

class IsYearCompositeNumberTest extends \PHPUnit_Framework_TestCase
{
    public function testTODO()
    {
        $date = new DateTime();
        $predicate = new IsYearCompositeNumber();
        $predicate->evaluate($date);
        //$this->markTestIncomplete("TODO");
    }
}
