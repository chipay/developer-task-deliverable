<?php

namespace GSibay\DeveloperTask\Transformer;

use GSibay\DeveloperTask\Transformer\Transformer;

class ArrayTransformer implements Transformer
{
    private $transformer;

    public function __construct(Transformer $elementTransformer)
    {
        if ($elementTransformer === null) {
            throw \RuntimeException("No element transformer was provided");
        }
        $this->transformer = $elementTransformer;
    }

    /**
     * (non-PHPdoc)
     * @see GSibay\DeveloperTask\Transformer.Transformer::transform()
     */
    public function transform($array)
    {
       return array_map(array($this->transformer, 'transform'), $array);
    }
}
