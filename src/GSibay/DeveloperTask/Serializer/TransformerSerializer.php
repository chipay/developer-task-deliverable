<?php

namespace GSibay\DeveloperTask\Serializer;

use JMS\Serializer\SerializerInterface;
use GSibay\DeveloperTask\Transformer\Transformer;

/**
 *
 * A serializer adapter. One transformation is performed
 * after serialization and another one is applied before deserialization.
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
    private $postSerializationTransformer;

    /**
     *
     * @var GSibay\DeveloperTask\Transformer\Transformer
     */
    private $preDeserializationTransformer;

    /**
     * Constructor.
     * @param JMS\Serializer\SerializerInterface $serializer The serializer to wrap.
     * @param Gsibay\DeveloperTask\Transformer\Transformer $postSerializationTransformer The transformer used after serialization
     * @param Gsibay\DeveloperTask\Transformer\Transformer $preDeserializationTransformer The transformer used before deserialization
     */
    public function __construct($serializer, $postSerializationTransformer, $preDeserializationTransformer)
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
        //return $this->serializer->serialize($data, $format, $context);
        return $this->postSerializationTransformer->transform($this->serializer->serialize($data, $format, $context));
    }
    /**
     * (non-PHPdoc)
     * @see JMS\Serializer.SerializerInterface::deserialize()
     */
    public function deserialize($data, $type, $format, DeserializationContext $context = null)
    {
        return $this->serializer->deserialize($this->preDeserializationTransformer->transform($data), $type, $format, $context);
    }

}