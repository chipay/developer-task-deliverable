<?php

namespace GSibay\DeveloperTask\Tests\Serializer;

use JMS\Serializer\SerializerBuilder;
use GSibay\DeveloperTask\Serializer\TransformerSerializer;
use GSibay\DeveloperTask\Transformer\ClosureTransformer;
use GSibay\DeveloperTask\Serializer\SerializableTimeDates;
use GSibay\DeveloperTask\Serializer\Serializable\SerializableDate;
use \DateTime as DateTime;
use \DateTimeZone as DateTimeZone;

class SerializableDatesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUpBeforeClass()
     */
    public static function setUpBeforeClass()
    {
        var_dump(__DIR__."/../../../../../vendor/jms/serializer/src");
        // Bootstrap the JMS custom annotations for Object mapping (serializatin/deserialization)
        \Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
                'JMS\Serializer\Annotation',
                __DIR__.'/../../../../../vendor/jms/serializer/src'
        );
    }
    
    public function testSerializableDates_EmptyArray_NoRows()
    {
        
        $serializableDates = new SerializableTimeDates(array());

        $serialized = SerializerBuilder::create()->build()->serialize($serializableDates, 'xml');;
        
        $expectedTransformedXml = <<<EOB
<?xml version='1.0' encoding='UTF-8'?>
<timestamps/>
EOB;
        
        $this->assertXmlStringEqualsXmlString($expectedTransformedXml, $serialized);
    }
    
    public function testSerializableDates_OneDate_OneRow()
    {
        $timeZone = new DateTimeZone('GMT');
        $dates = array(new DateTime('2009-06-30 13:00:00', $timeZone));
        
        $serializableDate = new SerializableDate(new DateTime('2009-06-30 13:00:00', $timeZone));
        $serializableDates = new SerializableTimeDates(array($serializableDate));
        $serialized = SerializerBuilder::create()->build()->serialize($serializableDates, 'xml');;
        
        $expectedTransformedXml = <<<EOB
<?xml version='1.0' encoding='UTF-8'?>
<timestamps>
    <timestamp time='1246406400' text='2009-06-30 13:00:00' />
</timestamps>
EOB;
        
        $this->assertXmlStringEqualsXmlString($expectedTransformedXml, $serialized);
    }
    
}