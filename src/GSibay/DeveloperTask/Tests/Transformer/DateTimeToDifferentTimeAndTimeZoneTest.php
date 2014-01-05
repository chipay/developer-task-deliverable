<?php

namespace GSibay\DeveloperTask\Tests\Transformer;

use GSibay\DeveloperTask\Transformer\DateTimeToDifferentTimeAndTimeZone;

use \DateTime as DateTime;
use \DateTimeZone as DateTimeZone;

class DateTimeToDifferentTimeAndTimeZoneTest extends \PHPUnit_Framework_TestCase
{

    public function test_Transform_12__30__30__GMT_To_14__00__00__PST()
    {
        $transformer = new DateTimeToDifferentTimeAndTimeZone('PST', 14, 0, 0);
        $dateToTransform = DateTime::createFromFormat('d-m-Y H:i:s', '19-10-1980 14:00:00', new DateTimeZone('GMT'));
        $expected = DateTime::createFromFormat('d-m-Y H:i:s', '19-10-1980 14:00:00', new DateTimeZone('PST'));
        $this->assertEquals($expected, $transformer->transform($dateToTransform));
    }

    public function test_Transform_12__30__30__PST_To_14__00__00__GMT()
    {
        $transformer = new DateTimeToDifferentTimeAndTimeZone('GMT', 14, 0, 0);
        $dateToTransform = DateTime::createFromFormat('d-m-Y H:i:s', '12-2-1998 12:30:00', new DateTimeZone('PST'));
        $expected = DateTime::createFromFormat('d-m-Y H:i:s', '12-2-1998 14:00:00', new DateTimeZone('GMT'));
        $this->assertEquals($expected, $transformer->transform($dateToTransform));
    }

    public function test_Transform_13__00__00__GMT_To_12__00__00__PST()
    {
        $transformer = new DateTimeToDifferentTimeAndTimeZone('PST', 12, 0, 0);
        $dateToTransform = DateTime::createFromFormat('d-m-Y H:i:s', '19-10-1980 13:00:00', new DateTimeZone('GMT'));
        $expected = DateTime::createFromFormat('d-m-Y H:i:s', '19-10-1980 12:00:00', new DateTimeZone('PST'));
        $this->assertEquals($expected, $transformer->transform($dateToTransform));
    }

    public function test_Transform_01__00__00__GMT_To_11__00__00__PST_TimeSetInGMTPreviousDay()
    {
        $transformer = new DateTimeToDifferentTimeAndTimeZone('PST', 11, 0, 0);
        $dateToTransform = DateTime::createFromFormat('d-m-Y H:i:s', '10-10-1975 01:00:00', new DateTimeZone('GMT'));
        $expected = DateTime::createFromFormat('d-m-Y H:i:s', '9-10-1975 11:00:00', new DateTimeZone('PST'));
        $this->assertEquals($expected, $transformer->transform($dateToTransform));
    }

}
