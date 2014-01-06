<?php

namespace GSibay\DeveloperTask\Tests\Transformer;

use GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTimeContainer;
use GSibay\DeveloperTask\Transformer\DateTimeToSerializableDateTime;
use GSibay\DeveloperTask\Transformer\DateTimesToSerializableDateTimeContainer;
use \DateTime as DateTime;
use \DateTimeZone as DateTimeZone;
use \Mockery as M;

class DateTimesToSerializableDateTimeContainerTest extends \PHPUnit_Framework_TestCase
{
    public function test_Transform_EmptyDateTimes_ContinerHasEmptyArray()
    {
        $dateTimesToSerializableDateTimes = M::mock('GSibay\DeveloperTask\Transformer\ArrayTransformer');
        $dateTimesToSerializableDateTimes->shouldReceive('transform')->once()->with(array())->andReturn(array())->ordered();
        
        $transformer = new DateTimesToSerializableDateTimeContainer($dateTimesToSerializableDateTimes);
        
        $this->assertEquals(new SerializableDateTimeContainer(array()), $transformer->transform(array()));
    }

    public function test_Transform_ThreeDateTimes_ContainerHasThreeTransformedDateTimes()
    {
        $date1 = M::mock('\DateTime');
        $transformedDate1 = M::mock('\DateTime');

        $date2 = M::mock('\DateTime');
        $transformedDate2 = M::mock('\DateTime');
        
        $date3 = M::mock('\DateTime');
        $transformedDate3 = M::mock('\DateTime');
        
        $dates = array($date1, $date2, $date3);
        
        $transformedDates = array($transformedDate1, $transformedDate2, $transformedDate3);
        
        $dateTimesToSerializableDateTimes = M::mock('GSibay\DeveloperTask\Transformer\ArrayTransformer');
        $dateTimesToSerializableDateTimes->shouldReceive('transform')->once()->with($dates)->andReturn($transformedDates);
        
        $transformer = new DateTimesToSerializableDateTimeContainer($dateTimesToSerializableDateTimes);
        
        $this->assertEquals(new SerializableDateTimeContainer($transformedDates), $transformer->transform($dates));
    }
}
