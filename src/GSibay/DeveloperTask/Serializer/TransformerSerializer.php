<?php

namespace GSibay\DeveloperTask\Serializer;

use JMS\Serializer\SerializerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\DeserializationContext;
use GSibay\DeveloperTask\Transformer\Transformer;

/**
 *
 * A serializer adapter. One transformation is performed
 * after serialization and another one is applied before deserialization.
 * It is not required to provide both Transformers. If not provided
 * then that transformation will have no effect (i.e. it will be
 * the identity transformation).
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
    private $postSerializationTransformer;

    /**
     *
     * @var GSibay\DeveloperTask\Transformer\Transformer
     */
    private $preDeserializationTransformer;

    /**
     * If a transformer is not provided then that transformation will have no effect.
     * @param JMS\Serializer\SerializerInterface           $serializer                    The serializer to wrap.
     * @param Gsibay\DeveloperTask\Transformer\Transformer $postSerializationTransformer  The transformer used after serialization
     * @param Gsibay\DeveloperTask\Transformer\Transformer $preDeserializationTransformer The transformer used before deserialization
     */
    public function __construct($serializer, $postSerializationTransformer = null, $preDeserializationTransformer = null)
    {
        $this->serializer = $serializer;
        $this->postSerializationTransformer = $postSerializationTransformer;
        $this->preDeserializationTransformer = $preDeserializationTransformer;
    }

    /**
     * (non-PHPdoc)
     * @see JMS\Serializer.SerializerInterface::serialize()
     */
    public function serialize($data, $format, SerializationContext $context = null)
    {
        $serializedData = $this->serializer->serialize($data, $format, $context);

        return $this->transform($serializedData, $this->postSerializationTransformer);
    }
    /**
     * (non-PHPdoc)
     * @see JMS\Serializer.SerializerInterface::deserialize()
     */
    public function deserialize($data, $type, $format, DeserializationContext $context = null)
    {
        $transformedData = $this->transform($data, $this->preDeserializationTransformer);

        return $this->serializer->deserialize($transformedData, $type, $format, context);
    }

    /**
     * Returns the Transformer's transformation iff
     * $transformer is not null. Otherwise $data is returned.
     *
     * @param $data
     * @param Transformer $transformer
     *                                 @return $data or transformed $data
     */
    private function transform($data, Transformer $transformer)
    {
        if ($transformer != null) {
            return $transformer->transform($data);
        } else {
            return $data;
        }
    }
}
