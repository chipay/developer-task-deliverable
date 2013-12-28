<?php

namespace GSibay\DeveloperTask\Tests\Serializer;

use JMS\Serializer\SerializerBuilder;
use GSibay\DeveloperTask\Serializer\SerializableTimeDates;
use \DateTime as DateTime;

/**
 * 
 * Tests for serialization of dates with custom format
 * @author gsibay
 *
 */
class CustomDateTimeSerializerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUpBeforeClass()
     */
    public static function setUpBeforeClass()
    {
    }
    
    public function testSerializeOneDate() 
    {
        var_dump(__DIR__."/../../../../../vendor/jms/serializer/src");
        // Bootstrap the JMS custom annotations for Object mapping (serializatin/deserialization)
        \Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
                'JMS\Serializer\Annotation',
                __DIR__.'/../../../../../vendor/jms/serializer/src'
        );
        
        /*
        $serializer = SerializerBuilder::create()->build();
        $date = new DateTime('1980-10-29');
        $dates = array($date, new DateTime('1990-10-29'));
        //var_dump($dates);
        
        $serializableDates = new SerializableTimeDates();
        //var_dump($serializableDates);
        $serializableDates->setDates($dates);
        
        $serialized = $serializer->serialize($serializableDates, 'xml');
        var_dump($serialized);
        ///$this->assertEquals($date->format(\DateTime::ISO8601), $serialized);
        
        */
    }
    /*
    public function testSerializerArrayDates()
    {
        
    }*/
}