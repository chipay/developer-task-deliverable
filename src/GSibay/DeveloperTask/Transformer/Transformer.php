<?php

namespace GSibay\DeveloperTask\Transformer;

/**
 * Transforms an object into another object
 * @author gsibay
 *
 */
interface Transformer
{
    /**
     * Transforms the object
     * @param $anObject The object to be transformed.
     * @returns The transformed object.
     */
    public function transform($anObject);
}
