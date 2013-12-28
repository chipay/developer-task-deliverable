<?php

/**
 * This file is part of the DeveloperTask package
 *
 * @author gsibay
 */

namespace GSibay\DeveloperTask\Serializer;

use \DateTime as DateTime;

/**
 * @author german
 */ 
class SerializableTimeDates
{

    /**
     * 
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
