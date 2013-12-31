<?php

namespace GSibay\DeveloperTask\Transformer;

abstract class AbstractTransformer implements Transformer
{
    /**
     * (non-PHPdoc)
     * @see GSibay\DeveloperTask\Transformer.Transformer::getTransformAsCallable()
     */
    public function getTransformAsCallable()
    {
        //TODO: change and define a closure
        return array($this, 'transform');
    }
}
