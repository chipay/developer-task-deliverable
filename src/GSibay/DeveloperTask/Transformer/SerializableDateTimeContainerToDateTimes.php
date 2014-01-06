<?php

namespace GSibay\DeveloperTask\Transformer;

use GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTimeContainer;

/**
 * Transforms a SerializableDateTimeContainer into an array of DateTime.
 * The array of DateTime contains the same dates and in the same order
 * as the SerializableDateTime in the SerializableDateTimeContainer.
 *
 * @author gsibay
 *
 */
class SerializableDateTimeContainerToDateTimes implements Transformer
{

    /**
     * (non-PHPdoc)
     * @see GSibay\DeveloperTask\Transformer.Transformer::transform()
     */
    public function transform($serializableDateTimeContainer)
    {
        return $serializableDateTimeArray = array_map(
                function($serializableDateTime) 
                {
                    return clone $serializableDateTime->getDate();
                }, $serializableDateTimeContainer->getDates());
    }

}
