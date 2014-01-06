<?php

namespace GSibay\DeveloperTask\Transformer;

/**
 * Transforms a \TimeDate to a
 * GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTime
 * @author gsibay
 *
 */
use GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTime;

class DateTimeToSerializableDateTime implements Transformer
{

    /**
     * (non-PHPdoc)
     * @see GSibay\DeveloperTask\Transformer.Transformer::transform()
     */
    public function transform($anObject)
    {
        return new SerializableDateTime($anObject);
    }
}
