<?php

namespace GSibay\DeveloperTask\Transformer;

interface Transformer
{
    /**
     * Returns the closure that performs the transformation
     * @param $anObject
     * @returns Closure
     */
    public function transform($anObject);
}
