<?php

namespace GSibay\DeveloperTask\Tests\Transformer;

use GSibay\DeveloperTask\Tests\DateTime\TimeDateUtilsTest;

use GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTimeContainer;
use GSibay\DeveloperTask\Transformer\DateTimeToSerializableDateTime;
use GSibay\DeveloperTask\Transformer\DateTimesToSerializableDateTimeContainer;
use \DateTime as DateTime;
use \DateTimeZone as DateTimeZone;
use \Mockery as m;

class DateTimesToSerializableDateTimeContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testTransform_EmptyDateTimes_ContinerHasEmptyArray()
    {
        $dateTimeToSerializableDateTime = 
            m::mock('GSibay\DeveloperTask\Transformer\DateTimeToSerializableDateTime');
        $transformer = new DateTimesToSerializableDateTimeContainer($dateTimeToSerializableDateTime);
        $this->assertEquals(new SerializableDateTimeContainer(array()), $transformer->transform(array()));
    }

    public function testTransform_ThreeDateTimes_ContainerHasThreeTransformedDateTimes()
    {
        $date1 = new DateTime('20-10-1990');
        $date1->setTimezone(new DateTimeZone('PST'));
        $transformedDate1 = m::mock('\DateTime');
        
        $date2 = new DateTime('19-07-1974');
        $date2->setTimezone(new DateTimeZone('GMT'));
        $transformedDate2 = m::mock('\DateTime');
        
        $date3 = new DateTime('01-06-1986');
        $date3->setTimezone(new DateTimeZone('America/Aruba'));
        $transformedDate3 = m::mock('\DateTime');
        
        $dates = array($date1, $date2, $date3);
        $expected = new SerializableDateTimeContainer(
                array($transformedDate1, $transformedDate2, $transformedDate3));
        
        $dateTimeToSerializableDateTime =
            m::mock('GSibay\DeveloperTask\Transformer\DateTimeToSerializableDateTime');
        $dateTimeToSerializableDateTime->shouldReceive('transform')->once()->with($date1)->andReturn($transformedDate1)->ordered();
        $dateTimeToSerializableDateTime->shouldReceive('transform')->once()->with($date2)->andReturn($transformedDate2)->ordered();
        $dateTimeToSerializableDateTime->shouldReceive('transform')->once()->with($date3)->andReturn($transformedDate3)->ordered();
        
        $transformer = new DateTimesToSerializableDateTimeContainer($dateTimeToSerializableDateTime);
        
        $this->assertEquals($expected, $transformer->transform($dates));
    }
}
