<?php

/**
 * This file is part of the DeveloperTask package
 *
 * @author gsibay
 */

namespace GSibay\DeveloperTask\Serializer\Serializable;

use JMS\Serializer\Annotation as JMS;
use JMS\Serializer\Annotation\Type;

use \DateTime as DateTime;

/**
 * @author german
 * 
 */ 
class SerializableDate
{
    /**
     * 
     * @var SerializableTimeDates
     */
    private $father;
    
    /**
     * @JMS\XmlAttribute 
     * @JMS\Type("DateTime<'Y-m-d H:i:s'>")
     * @JMS\SerializedName("text")
     * @var \DateTime
     */
    private $date;
    
    /**
     * @JMS\Type("DateTime<'U','PST'>")
     * @JMS\XmlAttribute
     * @JMS\SerializedName("time")
     * @JMS\VirtualProperty
     */
    public function getTime()
    {
        return $this->msg;//->getTimestamp();
    }

    
    /**
     * 
     */
    public function __construct($date)
    {
       $this->date = $date; 
    }
}
