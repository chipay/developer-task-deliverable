<?php

namespace GSibay\DeveloperTask\Transformer;

/**
 * Transforms an array of \TimeDate to a
 * GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTimeContainer
 * @author gsibay
 *
 */
use GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTimeContainer;

/**
 * Transforms an array of DateTime to a SerializableDateTimeContainer.
 * The SerializableDateTimeContainer contains the same dates and in the same
 * order but transformed to SerializableDateTime objects.
 * 
 * @author gsibay
 *
 */
class DateTimesToSerializableDateTimeContainer extends AbstractTransformer
{

    /**
     * Transformer to transform DateTime to SerializableDateTime.
     * @var Transformer
     */
    private $toSerializableDateTime;

    public function __construct(Transformer $dateTimeTransformer)
    {
        $this->toSerializableDateTime = $dateTimeTransformer;
    }

    /**
     * (non-PHPdoc)
     * @see GSibay\DeveloperTask\Transformer.Transformer::transform()
     */
    public function transform($anObject)
    {
        // transform DateTime[] to SerializableDateTime[]
        $serializableDateTimeArray = array_map(array($this->toSerializableDateTime, 'transform'), $anObject);
        return new SerializableDateTimeContainer($serializableDateTimeArray);
    }

}
