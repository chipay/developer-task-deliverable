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
 * @JMS\AccessorOrder("custom", custom = {"date", "getText"})
 * @author german
 * 
 */ 
class SerializableDate
{
    /**
     * 
     * @var SerializableTimeDates
     */
    //private $father;
    
    /**
     * @JMS\XmlAttribute 
     * @JMS\Type("DateTime<'U'>")
     * @JMS\SerializedName("time")
     * @var \DateTime
     */
    private $date;
    
    /**
     * @JMS\Type("DateTime<'Y-m-d H:i:s'>")
     * @JMS\XmlAttribute
     * @JMS\SerializedName("text")
     * @JMS\VirtualProperty
     */
    public function getText()
    {
        return $this->date;
    }
    
    /**
     * 
     */
    public function __construct($date)
    {
       $this->date = $date; 
    }
}
