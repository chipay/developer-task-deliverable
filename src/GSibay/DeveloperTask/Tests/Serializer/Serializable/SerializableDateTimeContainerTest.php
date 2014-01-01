<?php

namespace GSibay\DeveloperTask\Tests\Serializer\Serializable;

use GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTimeContainer;
use GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTime;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use \DateTime as DateTime;
use \DateTimeZone as DateTimeZone;

class SerializableDateTimeContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The serializer service
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUpBeforeClass()
     */
    public static function setUpBeforeClass()
    {
        // Bootstrap the JMS custom annotations for Object mapping (serializatin/deserialization)
        \Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
                'JMS\Serializer\Annotation',
                __DIR__.'/../../../../../../vendor/jms/serializer/src'
        );
    }

    public function setUp()
    {
        $this->serializer = SerializerBuilder::create()->build();
    }

    /**
     *
     * @param  SerializableDateTimeContainer $dates
     * @return string
     */
    private function serializeToXML(SerializableDateTimeContainer $dates)
    {
        return $this->serializer->serialize($dates, 'xml');
    }

    /**
     *
     * @param $serializedDates
     * @return SerializableDateTimeContainer
     */
    private function deserializeFromXML($serializedDates)
    {
        return $this->serializer->deserialize($serializedDates, "GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTimeContainer", 'xml');
    }

    /**
     * Creates the SerializalbeDateTimeContainer from $dates, serializes it and asserts
     * that the serialization is correct. Then deserializes it an asserts that the
     * deserialized object is equals to $dates.
     * @param \DateTime[] $dates
     */
    private function assertSerializationAndDeserializationsBehavesAsExpected(array $dates)
    {
        $serializableDateTimeContainer = $this->createSerializableDateTimeContainer($dates);
        $serialized = $this->serializeAndCheckXML($serializableDateTimeContainer, $dates);
        $this->deserializeAndCheckHaveSameTimestamps($serializableDateTimeContainer, $serialized);
    }

    /**
     * Serialize the $serializableDateTimeContainer and assert that the serialized object is
     * as expected. Returns the serialized object (in xml format).
     *
     * @param  SerializableDateTimeContainer $serializableDateTimeContainer
     * @param  array                         $dates
     * @return string
     */
    private function serializeAndCheckXML(SerializableDateTimeContainer $serializableDateTimeContainer, array $dates)
    {
        $serialized = $this->serializeToXML($serializableDateTimeContainer);

        $format = 'Y-m-d H:i:s';
        $expectedTransformedXml = "<?xml version='1.0' encoding='UTF-8'?><timestamps>";

        array_walk($dates,
                function (\DateTime $date) use ($format, &$expectedTransformedXml) {
                    $timestamp = $date->getTimestamp();
                    $text = $date->format($format);
                    $expectedTransformedXml .="<timestamp time='$timestamp' text='$text' />";
                });

        $expectedTransformedXml = $expectedTransformedXml .'</timestamps>';

        $this->assertXmlStringEqualsXmlString($expectedTransformedXml, $serialized);

        return $serialized;
    }

    /**
     * Creates the SerializableDateTimeContainer containing
     * one SerializableDateTime for each DateTime in $dates
     *
     * @param  array                                                                       $dates
     * @return \GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTimeContainer
     */
    private function createSerializableDateTimeContainer(array $dates)
    {
        $serializableDateArray = array_map(
            function (\DateTime $date) {
                return new SerializableDateTime($date);
            }, $dates);

        return new SerializableDateTimeContainer($serializableDateArray);
    }

    /**
     *
     * @param SerializableDateTimeContainer $serializableDates
     *                                                         @param $serialized
     */
    public function deserializeAndCheckHaveSameTimestamps(SerializableDateTimeContainer $serializableDates, $serialized)
    {
        $deserialized = $this->deserializeFromXML($serialized);
        $this->assertNotEmpty($deserialized);

        //assertEquals is not used because PHPUnitTest DateTime comparator will check timezone.
        //for the serialization and deserialization only timestamp is important.
        $this->assertTrue($serializableDates == $deserialized);
    }

    public function testSerializeAndDeserializeSerializableTimeDates_EmptyArray_NoRowsExpected()
    {
        $dates = array();
        $this->assertSerializationAndDeserializationsBehavesAsExpected($dates);
    }

    public function testSerializeAndDeserializeSerializableTimeDates_OneDateWithDateTimeZoneGMT_OneRowExpected()
    {
        $dates = array(new DateTime('1972-02-28 13:00:00', new DateTimeZone('GMT')));
        $this->assertSerializationAndDeserializationsBehavesAsExpected($dates);
    }

    public function testSerializeSerializableTimeDates_OneDateWithDateTimeZonePST_OneRowExpected()
    {
        $dates = array(new DateTime('1999-12-31 11:12:13', new DateTimeZone('PST')));
        $this->assertSerializationAndDeserializationsBehavesAsExpected($dates);
    }

    public function testSerializeSerializableTimeDates_ThreeDatesWithDefaultTimeZone_ThreeRowsInTheRightOrderExpected()
    {
        $dates = array(new DateTime('1987-12-28 07:34:50'), new DateTime('2014-08-01 23:59:59'), new DateTime('1971-05-17 12:23:57'));
        $this->assertSerializationAndDeserializationsBehavesAsExpected($dates);
    }

    /**
     * This test is actually one test for each timezone in Asia
     */
    public function testSerializeSerializableTimeDates_FourDatesWithEveryAsianTimeZone_FourRowsInTheRightOrderExpected()
    {
        $dates = array(new DateTime('1987-12-28 07:34:50'), new DateTime('2014-08-01 23:59:59'),
                new DateTime('1971-05-17 12:23:57'), new DateTime('2001-12-30 14:36:36'));

        $asian_timezone_Ids = \DateTimeZone::listIdentifiers(\DateTimeZone::ASIA);
        array_walk($asian_timezone_Ids,
                function ($timeZoneId) use ($dates) {
                    $timeZone = new DateTimeZone($timeZoneId);
                    // set the time zone to $time_zoneAbbreviation for each date
                    array_walk($dates,
                            function ($date) use ($timeZone) {
                                $date->setTimezone($timeZone);
                            });
                    $this->assertSerializationAndDeserializationsBehavesAsExpected($dates);
                });
    }

}
