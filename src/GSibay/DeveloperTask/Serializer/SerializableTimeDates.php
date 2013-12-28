<?php

/**
 * This file is part of the DeveloperTask package
 *
 * @author gsibay
 */

namespace GSibay\DeveloperTask\Serializer;

use JMS\Serializer\Annotation as JMS;
use \DateTime as DateTime;

/**
 * 
 * @JMS\XmlRoot("timestamps") 
 * 
 * @author gsibay
 */ 
class SerializableTimeDates
{

    /**
     * 
     * @JMS\XmlList(inline = true, entry = "timestamp")
     * @var SerializableDate[]
     */
    private $dates;
     
    /**
     * 
     * @param SerializableDate[] $serializableDates
     */
    public function __construct($serializableDates)
    {
        $this->dates = $serializableDates; 
    }
    
}
