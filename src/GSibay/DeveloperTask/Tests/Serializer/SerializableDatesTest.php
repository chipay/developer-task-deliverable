<?php

namespace GSibay\DeveloperTask\Tests\Serializer\Serializable;

use GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTimeContainer;
use GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTime;
use JMS\Serializer\SerializerBuilder;
use \DateTime as DateTime;

//TODO: try to clean up these tests to not depend on anything. Maybe only the Serializer
class SerializableTimeDatesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUpBeforeClass()
     */
    public static function setUpBeforeClass()
    {
        // Bootstrap the JMS custom annotations for Object mapping (serializatin/deserialization)
        \Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
                'JMS\Serializer\Annotation',
                __DIR__.'/../../../../../vendor/jms/serializer/src'
        );
    }

    public function testSerializableTimeDates_EmptyArray_NoRows()
    {

        $serializableDates = new SerializableDateTimeContainer(array());

        $serialized = SerializerBuilder::create()->build()->serialize($serializableDates, 'xml');;

        $expectedTransformedXml = <<<EOB
<?xml version='1.0' encoding='UTF-8'?>
<timestamps/>
EOB;

        $this->assertXmlStringEqualsXmlString($expectedTransformedXml, $serialized);
    }

    public function testSerializableTimeDates_OneDate_OneRow()
    {
        $date = new DateTime('2009-06-30 13:00:00');
        $serializableDate = new SerializableDateTime($date);
        $serializableDates = new SerializableDateTimeContainer(array($serializableDate));

        $serialized = SerializerBuilder::create()->build()->serialize($serializableDates, 'xml');;

        $time = $date->getTimestamp();
        $text = $date->format('Y-m-d H:i:s');
        $expectedTransformedXml = <<<EOB
<?xml version='1.0' encoding='UTF-8'?>
<timestamps>
    <timestamp time='$time' text='$text' />
</timestamps>
EOB;

        $this->assertXmlStringEqualsXmlString($expectedTransformedXml, $serialized);
    }

}
