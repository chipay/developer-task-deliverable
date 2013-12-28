<?php

/**
 * This file is part of the DeveloperTask package
 *
 * @author gsibay
 */

namespace GSibay\DeveloperTask\Service;

use \DateTime as DateTime;

/**
 * Command to generate and save the dates
 *
 * @author gsibay
 *
 */
interface DateGeneratorService
{
    /**
     * @return array(DateTime)
     */
    public function generateDates();
}