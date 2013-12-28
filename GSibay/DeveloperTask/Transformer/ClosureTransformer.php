<?php

namespace GSibay\DeveloperTask\Transformer;

/**
 * 
 * Transformer defined by a closure.
 * 
 * @author gsibay
 *
 */
class ClosureTransformer implements Transformer
{
    /**
     * 
     * @var \Closure (anObject) -> (anotherObject)
     */
    private $closure;
    
    public function __construct($closure)
    {
        $this->closure = $closure;    
    }
    
    /**
     * (non-PHPdoc)
     * @see Gsibay\DeveloperTask\Transformer.Transformer::transform()
     */
    public function transform($anObject)
    {
        return $this->closure($anObject);
    }
}