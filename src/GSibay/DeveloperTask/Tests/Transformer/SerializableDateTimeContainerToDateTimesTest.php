<?php

namespace GSibay\DeveloperTask\Tests\Transformer;

use GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTimeContainer;
use GSibay\DeveloperTask\Transformer\SerializableDateTimeContainerToDateTimes;
use GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTime;
use \DateTime as DateTime;
use \DateTimeZone as DateTimeZone;

class SerializableDateTimeToDateTimesTest extends \PHPUnit_Framework_TestCase
{

    private $transformer;

    /**
     * Builds the container with a SerializableDateTime for each element in the array
     * @param \DateTime[] $orginal
     */
    private function getSerializableDateTimeContainer($original)
    {
        $serializableDateTimes = array();
        foreach ($original as $date) {
            $serializableDateTimes[] = new SerializableDateTime($date);
        }

        return new SerializableDateTimeContainer($serializableDateTimes);
    }

    public function setup()
    {
        parent::setup();
        $this->transformer = new SerializableDateTimeContainerToDateTimes();
    }

    public function test_Transform_EmptyContainer_ReturnsEmptyArray()
    {
        $toTransform = new SerializableDateTimeContainer(array());
        $expected = array();

        $this->assertEquals($expected, $this->transformer->transform($toTransform));
    }

    public function test_Transform_ContainerWithOneDateTimePST_ReturnsArrayWithTheDate()
    {
        $date = new DateTime("now", new DateTimeZone('PST'));
        $original = array($date);
        $toTransform = $this->getSerializableDateTimeContainer($original);

        $transformed = $this->transformer->transform($toTransform);

        $this->assertEquals($original, $transformed);
    }

    public function test_Transform_ContainerWith4SerializableDates_ReturnsArrayWithTheFourDates()
    {
        $original = array(new DateTime("now", new DateTimeZone('GMT')),
                \DateTime::createFromFormat('d-m-Y', '12-4-1980', new DateTimeZone('PST')),
                \DateTime::createFromFormat('d-m-Y', '23-7-1975', new DateTimeZone('PST')),
                \DateTime::createFromFormat('d-m-Y', '31-12-2009', new DateTimeZone('PST')));
        $toTransform = $this->getSerializableDateTimeContainer($original);

        $transformed = $this->transformer->transform($toTransform);

        $this->assertEquals($original, $transformed);
    }

}
