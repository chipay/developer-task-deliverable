<?php

namespace GSibay\DeveloperTask\Tests\Serializer;

use GSibay\DeveloperTask\Transformer\Transformer;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;
use GSibay\DeveloperTask\Serializer\TransformerSerializer;
use \DateTime as DateTime;
use \DateTimeZone as DateTimeZone;
use \Mockery as M;

class TransformerSerializerTest extends \PHPUnit_Framework_TestCase
{

    public function test_Serialize_NoPreSerializationTransformer_ObjectSerializedWithNoTransformation()
    {
        $data = 'This is an object that will be serialized but not transformed';
        $dataSerializedByMock = 'This is the dummy object returned by the mocked serializer';

        $format = 'xml';
        $context = M::mock('JMS\Serializer\SerializationContext');

        // the tramsformer serializer should forward the parameters without changing them
        $mockedSerializer = M::mock('JMS\Serializer\SerializerInterface');
        $mockedSerializer->shouldReceive('serialize')->with($data, $format, $context)->once()->ordered()->andReturn($dataSerializedByMock);

        $transformerSerializer = new TransformerSerializer($mockedSerializer);

        $this->assertEquals($dataSerializedByMock, $transformerSerializer->serialize($data, $format, $context));
    }

    public function test_Deserialize_NoPostDerializationTransformer_ObjectSerializedWithNoTransformation()
    {
        $serializedData = 'This is the serialized data';
        $dataDeserializedByMock = 'This is the dummy object returned by the mocked serializer';

        $format = 'xml';
        $type = 'string';
        $context = M::mock('JMS\Serializer\DeserializationContext');

        // the tramsformer serializer should forward the parameters without changing them
        $mockedSerializer = M::mock('JMS\Serializer\SerializerInterface');
        $mockedSerializer->shouldReceive('deserialize')->with($serializedData, $type, $format, $context)->once()->andReturn($dataDeserializedByMock);

        $transformerSerializer = new TransformerSerializer($mockedSerializer);

        $this->assertEquals($dataDeserializedByMock, $transformerSerializer->deserialize($serializedData, $type, $format, $context));
    }

    public function test_Serialize_PreSerializationTransformerToSameType_ObjectTransformedAndSerialized()
    {
        $data = 'This is an object that will be transformed and then serialized';
        $dataTransformedByMock = 'This is the dummy object returned by the mocked transformer';
        $dataTransformedAndSerialized = 'object serialized and transformed';

        $format = 'xml';
        $context = M::mock('JMS\Serializer\SerializationContext');

        $mockedPreSerializationTransformer = M::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $mockedPreSerializationTransformer->shouldReceive('transform')->with($data)->once()->ordered()->andReturn($dataTransformedByMock);

        $mockedSerializer = M::mock('JMS\Serializer\SerializerInterface');
        $mockedSerializer->shouldReceive('serialize')->with($dataTransformedByMock, $format, $context)->once()->ordered()->andReturn($dataTransformedAndSerialized);

        $transformerSerializer = new TransformerSerializer($mockedSerializer, $mockedPreSerializationTransformer);

        $this->assertEquals($dataTransformedAndSerialized, $transformerSerializer->serialize($data, $format, $context));
    }

    public function test_Serialize_PreSerializationTransformerToDifferentType_ObjectTransformedAndSerialized()
    {
        $data = 'This is an object that will be transformed and then serialized';
        $dataTransformedByMock = \DateTime::createFromFormat('d-m-Y', '22-10-1980', new DateTimeZone('GMT'));
        $dataTransformedAndSerialized = 'object serialized and transformed';

        $format = 'xml';
        $context = M::mock('JMS\Serializer\SerializationContext');

        $mockedPreSerializationTransformer = M::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $mockedPreSerializationTransformer->shouldReceive('transform')->with($data)->once()->ordered()->andReturn($dataTransformedByMock);

        $mockedSerializer = M::mock('JMS\Serializer\SerializerInterface');
        $mockedSerializer->shouldReceive('serialize')->with($dataTransformedByMock, $format, $context)->once()->ordered()->andReturn($dataTransformedAndSerialized);

        $transformerSerializer = new TransformerSerializer($mockedSerializer, $mockedPreSerializationTransformer);

        $this->assertEquals($dataTransformedAndSerialized, $transformerSerializer->serialize($data, $format, $context));
    }

    public function test_Deserialize_PostDeserializationTransformerToSameType_ObjectDerializedAndTransformed()
    {
        $serializedData = 'This is the serialized data';
        $dataDeserializedByMock = 'This is the dummy object returned by the mocked serializer';
        $transformedDeserializedData = 'The transformed serialized data';

        $format = 'xml';
        $type = 'string';
        $context = M::mock('JMS\Serializer\DeserializationContext');

        $mockedSerializer = M::mock('JMS\Serializer\SerializerInterface');
        $mockedSerializer->shouldReceive('deserialize')->with($serializedData, $type, $format, $context)->once()->ordered()->andReturn($dataDeserializedByMock);

        $mockedPostDeserializationTransformer = M::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $mockedPostDeserializationTransformer->shouldReceive('transform')->with($dataDeserializedByMock)->once()->ordered()->andReturn($transformedDeserializedData);

        $transformerSerializer = new TransformerSerializer($mockedSerializer, null, $mockedPostDeserializationTransformer, 'string');

        $this->assertEquals($transformedDeserializedData, $transformerSerializer->deserialize($serializedData, $type, $format, $context));
    }

    public function test_Deserialize_PostDeserializationTransformerToDifferentType_ObjectDerializedAndTransformed()
    {
        $serializedData = \DateTime::createFromFormat('d-m-Y', '22-10-1980', new DateTimeZone('GMT'));
        $dataDeserializedByMock = 'This is the dummy object returned by the mocked serializer';
        $transformedDeserializedData = 'The transformed serialized data';

        $format = 'xml';
        $type = 'string';
        $context = M::mock('JMS\Serializer\DeserializationContext');

        $mockedSerializer = M::mock('JMS\Serializer\SerializerInterface');
        $mockedSerializer->shouldReceive('deserialize')->with($serializedData, '\DateTime', $format, $context)->once()->ordered()->andReturn($dataDeserializedByMock);

        $mockedPostDeserializationTransformer = M::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $mockedPostDeserializationTransformer->shouldReceive('transform')->with($dataDeserializedByMock)->once()->ordered()->andReturn($transformedDeserializedData);

        $transformerSerializer = new TransformerSerializer($mockedSerializer, null, $mockedPostDeserializationTransformer, '\DateTime');

        $this->assertEquals($transformedDeserializedData, $transformerSerializer->deserialize($serializedData, $type, $format, $context));
    }

    /**
     * @expectedException        \LogicException
     * @expectedExceptionMessage Post deserialization transformer has been set but not the type of the deserialized object.
     */
    public function test_Deserialize_PostDeserializationTransformerAndNoDeserializationTypeProvided_ExceptionThrown()
    {
        $serializedData = \DateTime::createFromFormat('d-m-Y', '22-10-1980', new DateTimeZone('GMT'));
        $dataDeserializedByMock = 'This is the dummy object returned by the mocked serializer';
        $transformedDeserializedData = 'The transformed serialized data';
    
        $format = 'xml';
        $type = 'string';
        $context = M::mock('JMS\Serializer\DeserializationContext');
    
        $mockedSerializer = M::mock('JMS\Serializer\SerializerInterface');
    
        $mockedPostDeserializationTransformer = M::mock('GSibay\DeveloperTask\Transformer\Transformer');
    
        $transformerSerializer = new TransformerSerializer($mockedSerializer, null, $mockedPostDeserializationTransformer);
    
        $transformerSerializer->deserialize($serializedData, $type, $format, $context);
    }
    
    public function test_Serialize_TransformersForBothDirectionsAndSameType_ObjectTransformedAndSerialized()
    {
        $data = 'This is an object that will be transformed and then serialized';
        $dataTransformedByMock = 'This is the dummy object returned by the mocked transformer';
        $dataTransformedAndSerialized = 'object serialized and transformed';

        $format = 'xml';
        $context = M::mock('JMS\Serializer\SerializationContext');

        $mockedPreSerializationTransformer = M::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $mockedPreSerializationTransformer->shouldReceive('transform')->with($data)->once()->ordered()->andReturn($dataTransformedByMock);

        $mockedPostSerializationTransformer = M::mock('GSibay\DeveloperTask\Transformer\Transformer');

        $mockedSerializer = M::mock('JMS\Serializer\SerializerInterface');
        $mockedSerializer->shouldReceive('serialize')->with($dataTransformedByMock, 'xml', $context)->once()->ordered()->andReturn($dataTransformedAndSerialized);

        $transformerSerializer = new TransformerSerializer($mockedSerializer, $mockedPreSerializationTransformer, $mockedPostSerializationTransformer);

        $this->assertEquals($dataTransformedAndSerialized, $transformerSerializer->serialize($data, $format, $context));
    }

    public function test_Deserialize_TransformersForBothDirectionsAndSameType_ObjectDeserializedAndTransformed()
    {
        $serializedData = 'This is the serialized data';
        $dataDeserializedByMock = 'This is the dummy object returned by the mocked serializer';
        $transformedDeserializedData = 'The transformed serialized data';

        $format = 'xml';
        $type = 'string';
        $context = M::mock('JMS\Serializer\DeserializationContext');

        $mockedSerializer = M::mock('JMS\Serializer\SerializerInterface');
        $mockedSerializer->shouldReceive('deserialize')->with($serializedData, $type, $format, $context)->once()->ordered()->andReturn($dataDeserializedByMock);

        $mockedPostDeserializationTransformer = M::mock('GSibay\DeveloperTask\Transformer\Transformer');
        $mockedPostDeserializationTransformer->shouldReceive('transform')->with($dataDeserializedByMock)->once()->ordered()->andReturn($transformedDeserializedData);

        $mockedPreSerializationTransformer = M::mock('GSibay\DeveloperTask\Transformer\Transformer');

        $transformerSerializer = new TransformerSerializer($mockedSerializer, $mockedPreSerializationTransformer, $mockedPostDeserializationTransformer, 'string');

        $this->assertEquals($transformedDeserializedData, $transformerSerializer->deserialize($serializedData, $type, $format, $context));
    }
}
