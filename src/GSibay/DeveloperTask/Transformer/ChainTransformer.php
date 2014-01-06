<?php

namespace GSibay\DeveloperTask\Transformer;

/**
 * Transformer that applies a sequence of transformations
 * specified by an array of Transformers.
 *
 * @author gsibay
 *
 */
class ChainTransformer implements Transformer
{

    /**
     * List of transformers to be applied
     * @var Transformer[]
     */
    private $transformers;

    public function __construct(array $tranformers)
    {
        $this->transformers = $tranformers;
    }

    /**
     * (non-PHPdoc)
     * @see GSibay\DeveloperTask\Transformer.Transformer::transform()
     */
    public function transform($anObject)
    {
        $current = $anObject;
        foreach ($this->transformers as $transformer) {
            $current = $transformer->transform($current);
        }

        return $current;
    }
}
