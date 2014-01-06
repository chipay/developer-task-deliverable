<?php

namespace GSibay\DeveloperTask\Serializer;

use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\DeserializationContext;
use GSibay\DeveloperTask\Transformer\Transformer;

/**
 *
 * A serializer adapter.
 *
 * One transformation is performed before serialization and another one is applied after deserialization.
 * It is not required to provide both Transformers. If a transformer is not provided during construction
 * then that transformation is notperformed.
 * object -> pre serialization transformation (if the transformer is present) -> serialization.
 * serialized object -> deserialization -> post deserialization transformation (if the transformer is present).
 * Clients using deserialize need to pass as a paramter the type of the object to deserialize. However if
 * there is a post serialization transformer that paramter will not be forwarded to the serializer. The
 * property $deserializedObjectType is used instead. Then the object is transformed into an object
 * of the type that the client is expecting.
 * For this reason the $deserializedObjectType must be given during construction if
 * a post deserialization transformer was provided.
 * Deserialization will throw a LogicException if post deserialization transformer
 * is provided but $deserializedObjectType is not.
 *
 * @author gsibay
 *
 */
class TransformerSerializer implements SerializerInterface
{
    /**
     *
     * @var JMS\Serializer\SerializerInterface
     */
    private $serializer;

    /**
     *
     * @var GSibay\DeveloperTask\Transformer\Transformer
     */
    private $preSerializationTransformer = null;

    /**
     *
     * @var GSibay\DeveloperTask\Transformer\Transformer
     */
    private $postDeserializationTransformer = null;

    /**
     *
     * @var string
     */
    private $deserializedObjectType = null;

    /**
     * @param JMS\Serializer\SerializerInterface           $serializer                     The serializer to wrap.
     * @param GSibay\DeveloperTask\Transformer\Transformer $preSerializationTransformer    The transformer used before serialization
     * @param GSibay\DeveloperTask\Transformer\Transformer $postDeserializationTransformer The transformer used after deserialization
     * @param string                                       $deserializedObjectType         The type of the object to deserialize. Used if and only if $postDeserializationTransformer was provided
     */
    public function __construct($serializer, $preSerializationTransformer = null, $postDeserializationTransformer = null, $deserializedObjectType = null)
    {
        $this->serializer = $serializer;
        $this->preSerializationTransformer = $preSerializationTransformer;
        $this->postDeserializationTransformer = $postDeserializationTransformer;
        $this->deserializedObjectType = $deserializedObjectType;
    }

    /**
     * (non-PHPdoc)
     * @see JMS\Serializer.SerializerInterface::serialize()
     */
    public function serialize($data, $format, SerializationContext $context = null)
    {
        $transformedData = $this->transform($data, $this->preSerializationTransformer);

        return $this->serializer->serialize($transformedData, $format, $context);
    }
    /**
     * (non-PHPdoc)
     * @see JMS\Serializer.SerializerInterface::deserialize()
     */
    public function deserialize($data, $type, $format, DeserializationContext $context = null)
    {
        if ($this->postDeserializationTransformer !== null) {
            if ($this->deserializedObjectType === null) {
                throw new \LogicException('Post deserialization transformer has been set but not the type of the deserialized object.');
            }

            $deserializedData =  $this->serializer->deserialize($data, $this->deserializedObjectType, $format, $context);
        } else {
            $deserializedData =  $this->serializer->deserialize($data, $type, $format, $context);
        }

        return $this->transform($deserializedData, $this->postDeserializationTransformer);
    }

    /**
     * Returns the Transformer's transformation iff
     * $transformer is not null. Otherwise $data is returned.
     *
     * @param $data
     * @param Transformer $transformer
     *                                 @return $data or transformed $data
     */
    private function transform($data, Transformer $transformer = null)
    {
        if ($transformer === null) {
            return $data;
        } else {
            return $transformer->transform($data);
        }
    }
}
