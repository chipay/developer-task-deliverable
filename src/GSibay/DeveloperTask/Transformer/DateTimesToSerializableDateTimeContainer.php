<?php

namespace GSibay\DeveloperTask\Transformer;

use GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTimeContainer;

/**
 * Transforms an array of DateTime to a SerializableDateTimeContainer.
 * The SerializableDateTimeContainer contains the same dates and in the same
 * order but transformed to SerializableDateTime objects.
 *
 * @author gsibay
 *
 */
class DateTimesToSerializableDateTimeContainer implements Transformer
{

    /**
     * Transformer to transform DateTime[] to SerializableDateTime[].
     * @var Transformer
     */
    private $toSerializableDateTimes;

    public function __construct(Transformer $dateTimeTransformer)
    {
        $this->toSerializableDateTimes = $dateTimeTransformer;
    }

    /**
     * (non-PHPdoc)
     * @see GSibay\DeveloperTask\Transformer.Transformer::transform()
     */
    public function transform($dates)
    {
        // transform DateTime[] to SerializableDateTime[]
        $serializableDateTimeArray = $this->toSerializableDateTimes->transform($dates);

        return new SerializableDateTimeContainer($serializableDateTimeArray);
    }

}
