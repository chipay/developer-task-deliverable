<?php

namespace GSibay\DeveloperTask\Transformer;

interface Transformer
{
    /**
     * Transforms the object
     * @param $anObject The object to be transformed.
     * @returns The transformed object.
     */
    public function transform($anObject);

    /**
     * @return callable Returns the callable that applies the transformation
     */
    public function getTransformAsCallable();
}
