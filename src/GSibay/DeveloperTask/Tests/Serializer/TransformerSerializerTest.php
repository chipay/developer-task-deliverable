<?php

namespace GSibay\DeveloperTask\Tests\Serializer;

use JMS\Serializer\SerializationContext;

use JMS\Serializer\SerializerBuilder;
use GSibay\DeveloperTask\Serializer\TransformerSerializer;
use GSibay\DeveloperTask\Transformer\ClosureTransformer;
use \DateTime as DateTime;
use \Mockery as m;

class TransformerSerializerTest extends \PHPUnit_Framework_TestCase
{
    public function testSerialization_NoPreSerializationTransformer_ObjectSerializedWithNoTransformation()
    {
        $data = 'This is an object that will be serialized but not transformed';
        $dataSerializedByMock = 'This is the dummy object returned by the mocked serializer';
        
        $format = 'xml';
        $context = m::mock('JMS\Serializer\SerializationContext');                
        
        // the tramsformer serializer should forward the parameters without changing them
        $mockedSerializer = m::mock('JMS\Serializer\SerializerInterface');
        $mockedSerializer->shouldReceive('serialize')->with($data, 'xml', $context)->andReturn($dataSerializedByMock);
        
        $transformerSerializer = new TransformerSerializer($mockedSerializer);
        
        $this->assertEquals($dataSerializedByMock, $transformerSerializer->serialize($data, $format, $context));
    }

    public function testDeserialization_NoPostDerializationTransformer_ObjectSerializedWithNoTransformation()
    {
        $serializedData = 'This is the serialized data';
        $dataDeserializedByMock = 'This is the dummy object returned by the mocked serializer';
    
        $format = 'xml';
        $type = 'string';
        $context = m::mock('JMS\Serializer\DeserializationContext');
    
        // the tramsformer serializer should forward the parameters without changing them
        $mockedSerializer = m::mock('JMS\Serializer\SerializerInterface');
        $mockedSerializer->shouldReceive('deserialize')->with($serializedData, $type, $format, $context)->andReturn($dataDeserializedByMock);
    
        $transformerSerializer = new TransformerSerializer($mockedSerializer);
    
        $this->assertEquals($dataDeserializedByMock, $transformerSerializer->deserialize($serializedData, $type, $format, $context));
    }
    
    public function testSerialization_PreSerializationTransformerSerializationTransformer_ObjectTransformedAndSerialized()
    {
        
        $data = 'This is an object that will be transformed and then serialized';
        $dataTransformedByMock = 'This is the dummy object returned by the mocked transformer';
        $dataTransformedAndSerialized = 'object serialized and transformed';
        
        $format = 'xml';
        $context = m::mock('JMS\Serializer\SerializationContext');
    
        $mockedPreSerializationTransformer = m::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $mockedPreSerializationTransformer->shouldReceive('transform')->with($data)->andReturn($dataTransformedByMock);

        $mockedSerializer = m::mock('JMS\Serializer\SerializerInterface');
        $mockedSerializer->shouldReceive('serialize')->with($dataTransformedByMock, 'xml', $context)->andReturn($dataTransformedAndSerialized);
        
        
        $transformerSerializer = new TransformerSerializer($mockedSerializer, $mockedPreSerializationTransformer);
    
        $this->assertEquals($dataTransformedAndSerialized, $transformerSerializer->serialize($data, $format, $context));
    }

    public function testSerialization_PostDeserializationTransformerSerializationTransformer_ObjectDerializedAndTransformed()
    {
        $serializedData = 'This is the serialized data';
        $dataDeserializedByMock = 'This is the dummy object returned by the mocked serializer';
        $transformedDeserializedData = 'The transformed serialized data';
        
        $format = 'xml';
        $type = 'string';
        $context = m::mock('JMS\Serializer\DeserializationContext');

        $mockedSerializer = m::mock('JMS\Serializer\SerializerInterface');
        $mockedSerializer->shouldReceive('deserialize')->with($serializedData, $type, $format, $context)->andReturn($dataDeserializedByMock);

        $mockedPostDeserializationTransformer = m::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $mockedPostDeserializationTransformer->shouldReceive('transform')->with($dataDeserializedByMock)->andReturn($transformedDeserializedData);
    
        $transformerSerializer = new TransformerSerializer($mockedSerializer, null, $mockedPostDeserializationTransformer);
    
        $this->assertEquals($transformedDeserializedData, $transformerSerializer->deserialize($serializedData, $type, $format, $context));
    }
    
    public function testSerialization_TransformersForBothDirections_ObjectTransformedAndSerialized()
    {
        $data = 'This is an object that will be transformed and then serialized';
        $dataTransformedByMock = 'This is the dummy object returned by the mocked transformer';
        $dataTransformedAndSerialized = 'object serialized and transformed';
        
        $format = 'xml';
        $context = m::mock('JMS\Serializer\SerializationContext');
        
        $mockedPreSerializationTransformer = m::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $mockedPreSerializationTransformer->shouldReceive('transform')->with($data)->andReturn($dataTransformedByMock);
        
        $mockedPostSerializationTransformer = m::mock('GSibay\DeveloperTask\Transformer\Transformer');
        
        $mockedSerializer = m::mock('JMS\Serializer\SerializerInterface');
        $mockedSerializer->shouldReceive('serialize')->with($dataTransformedByMock, 'xml', $context)->andReturn($dataTransformedAndSerialized);
        
        
        $transformerSerializer = new TransformerSerializer($mockedSerializer, $mockedPreSerializationTransformer, $mockedPostSerializationTransformer);
        
        $this->assertEquals($dataTransformedAndSerialized, $transformerSerializer->serialize($data, $format, $context));
    }

    public function testDeserialization_TransformersForBothDirections_ObjectDeserializedAndTransformed()
    {
        $serializedData = 'This is the serialized data';
        $dataDeserializedByMock = 'This is the dummy object returned by the mocked serializer';
        $transformedDeserializedData = 'The transformed serialized data';
        
        $format = 'xml';
        $type = 'string';
        $context = m::mock('JMS\Serializer\DeserializationContext');
        
        $mockedSerializer = m::mock('JMS\Serializer\SerializerInterface');
        $mockedSerializer->shouldReceive('deserialize')->with($serializedData, $type, $format, $context)->andReturn($dataDeserializedByMock);
        
        $mockedPostDeserializationTransformer = m::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $mockedPostDeserializationTransformer->shouldReceive('transform')->with($dataDeserializedByMock)->andReturn($transformedDeserializedData);
        
        $mockedPreSerializationTransformer = m::mock('GSibay\DeveloperTask\Transformer\Transformer');
        
        $transformerSerializer = new TransformerSerializer($mockedSerializer, $mockedPreSerializationTransformer, $mockedPostDeserializationTransformer);
        
        $this->assertEquals($transformedDeserializedData, $transformerSerializer->deserialize($serializedData, $type, $format, $context));
    }
}
