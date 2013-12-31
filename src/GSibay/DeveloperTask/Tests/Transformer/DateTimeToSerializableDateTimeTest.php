<?php

namespace GSibay\DeveloperTask\Tests\Transformer;

use GSibay\DeveloperTask\Transformer\DateTimeToSerializableDateTime;
use GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTime;
use \DateTime as DateTime;
use \DateTimeZone as DateTimeZone;

class DateTimeToSerializableDateTimeTest extends \PHPUnit_Framework_TestCase
{

    public function testTransformNowTimeDateDefaultTimeZone_EqualsCreateFromNowTimeDateDefaultTimeZone()
    {
        $transformer = new DateTimeToSerializableDateTime();
        $now = new DateTime();
        $transformed = $transformer->transform($now);
        $expected = new SerializableDateTime($now);
        $this->assertEquals($expected, $transformed);
    }

    public function testTransformNowTimeDatePST_EqualsCreateFromNowTimeDatePST()
    {
        $transformer = new DateTimeToSerializableDateTime();
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('PST'));

        $transformed = $transformer->transform($now);
        $expected = new SerializableDateTime($now);

        $this->assertEquals($expected, $transformed);
    }

    public function testTransformNowTimeDateGMT_EqualsCreateFromNowTimeDateGMT()
    {

        $transformer = new DateTimeToSerializableDateTime();
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('GMT'));

        $transformed = $transformer->transform($now);
        $expected = new SerializableDateTime($now);

        $this->assertEquals($expected, $transformed);
    }

    public function testTransformNowTimeDateGMT_NotEqualsCreateFromNowTimeDatePST()
    {
        $transformer = new DateTimeToSerializableDateTime();
        $nowGMT = new DateTime();
        $nowGMT->setTimezone(new DateTimeZone('GMT'));

        $nowPST = clone $nowGMT;
        $nowPST->setTimezone(new DateTimeZone('PST'));

        $transformed = $transformer->transform($nowGMT);
        $serializableDateTimePST = new SerializableDateTime($nowPST);
        $this->assertNotEquals($serializableDateTimePST, $transformed);
    }

    public function testTransformNowTimeDatePST_NotEqualsCreateFromNowTimeDateGMT()
    {
        $transformer = new DateTimeToSerializableDateTime();
        $nowPST = new DateTime();
        $nowPST->setTimezone(new DateTimeZone('PST'));

        $nowGMT = clone $nowPST;
        $nowGMT->setTimezone(new DateTimeZone('GMT'));

        $transformed = $transformer->transform($nowPST);
        $serializableDateTimeGMT = new SerializableDateTime($nowGMT);
        $this->assertNotEquals($serializableDateTimeGMT, $transformed);
    }

}
