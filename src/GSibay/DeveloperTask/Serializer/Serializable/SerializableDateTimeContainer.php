<?php

/**
 * This file is part of the DeveloperTask package
 *
 * @author gsibay
 */

namespace GSibay\DeveloperTask\Serializer\Serializable;

use JMS\Serializer\Annotation as JMS;
use \DateTime as DateTime;

/**
 * @JMS\XmlRoot("timestamps")
 * @author gsibay
 */
class SerializableDateTimeContainer
{

    /**
     * @JMS\XmlList(inline = true, entry = "timestamp")
     * @var DateTime[]
     */
    private $dates;

    /**
     *
     * @param DateTime[] $dates
     */
    public function __construct(array $dates)
    {
        $this->dates = $dates;
    }

}
