<?php

namespace GSibay\DeveloperTask\Transformer;

/**
 *
 * Transformer defined by a closure.
 * The closure receives an object and returns
 * the transformed object.
 *
 * TODO: do I use this? remove if not
 * @author gsibay
 *
 */
class ClosureTransformer extends AbstractTransformer
{
    /**
     * @var callable
     */
    private $closure;

    /**
     * The closure that performs the transformation.
     * @param \Closure $closure
     */
    public function __construct(callable $callable)
    {
        $this->closure = $callable;
    }

    /**
     * (non-PHPdoc)
     * @see Gsibay\DeveloperTask\Transformer.Transformer::transform()
     */
    public function transform($anObject)
    {
        return call_user_func($this->closure, $anObject);
    }
}
