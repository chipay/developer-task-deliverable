<?php

namespace GSibay\DeveloperTask\Tests\Transformer;

use GSibay\DeveloperTask\Transformer\DateTimeToSerializableDateTime;
use GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTime;

use \DateTime as DateTime;

class DateTimeToSerializableDateTimeTest extends \PHPUnit_Framework_TestCase
{
    public function testTransformDate_EqualsCreateFromDate()
    {
        //TODO: add more tests
        $transformer = new DateTimeToSerializableDateTime();
        $now = new DateTime();
        $transformed = $transformer->transform($now);
        $expected = new SerializableDateTime($now);
        $this->assertEquals($expected, $transformed);
    }
}
