<?php

namespace GSibay\DeveloperTask\Validator;

/**
 * Validates an object
 * @author gsibay
 *
 */
interface Validator
{
    /**
     * Performs the validation. The result
     * is true if the validation is passed and false
     * otherwise.
     * @param $object
     * @returns boolean The validation result
     */
    public function validate($object);
}