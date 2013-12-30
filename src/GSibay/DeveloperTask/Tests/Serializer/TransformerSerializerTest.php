<?php

namespace GSibay\DeveloperTask\Tests\Serializer;

use JMS\Serializer\SerializerBuilder;
use GSibay\DeveloperTask\Serializer\TransformerSerializer;
use GSibay\DeveloperTask\Transformer\ClosureTransformer;
use \DateTime as DateTime;

class TransformerSerializerTest extends \PHPUnit_Framework_TestCase
{
    public function testSerializationAndDeserialization_simpleObject()
    {
        $this->markTestSkipped('must be revisited.');
        /*
            TODO: IGNORE THIS TEST UNTIL I FIGURE OUT THE problem with closures

        $serializer = SerializerBuilder::create()->setDebug(true)->build();

        // create a no operation transformer
        $nopClosure = function ($anObject) { return $anObjet; };
        $nopTrasformer = new ClosureTransformer($nopClosure);

        $transformerSerializer = new TransformerSerializer($serializer, $nopTransformer, $nopTransformer);

        $objectToSerialize = array(new DateTime('1985-10-29'), new DateTime('1995-10-29'));
        $serializedObject = $transformerSerializer->serialize($objectToSerialize, 'xml');
        $deserializedObject = $transformerSerializer->deserialize($serializedObject, 'array<\DateTime>', 'xml');

        $this->assertEquals($objectToSerialize, $deserializedObject);
     */
    }

}
