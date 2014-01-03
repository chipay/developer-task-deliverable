<?php

namespace GSibay\DeveloperTask\Service;

/**
 * Service to organize an array
 *
 * @author gsibay
 *
 */
interface ArrayOrganizerService
{

    /**
     * Receives an array and returns a new organized array
     *
     * @param  array $array Objects to organize
     * @return array The organized Objects
     */
    public function organize(array $array);
}
