<?php

/**
 * This file is part of the DeveloperTask package
 *
 * @author gsibay
 */

namespace GSibay\DeveloperTask\Serializer\Serializable;

use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\XmlRoot("timestamps")
 * @author gsibay
 */
class SerializableDateTimeContainer
{

    /**
     * @JMS\XmlList(inline = true, entry = "timestamp")
     * @JMS\Type("array<GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTime>")
     * @var SerializableDateTime[]
     */
    private $dates;

    /**
     *
     * @param SerializableDateTime[] $dates
     */
    public function __construct(array $dates)
    {
        $this->dates = $dates;
    }

    public function getDates()
    {
        return $this->dates;
    }
}
