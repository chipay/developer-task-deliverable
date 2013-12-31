<?php

namespace GSibay\DeveloperTask\Transformer;

/**
 * Transforms an array of \TimeDate to a
 * GSibay\DeveloperTask\Serializer\Serializable\SerializableDateTimeContainer
 * @author gsibay
 *
 */
class DateTimesToSerializableDateTimeContainer extends AbstractTransformer
{

    /**
     * Transformer to transform TimeDate to a serializable object
     * @var Transformer
     */
    private $timeDateTransformer;

    public function __construct(Transformer $timeDateTransformer)
    {
        $this->timeDateTransformer = $timeDateTransformer;
    }

    /**
     * (non-PHPdoc)
     * @see GSibay\DeveloperTask\Transformer.Transformer::transform()
     */
    public function transform($anObject)
    {
        return $transformedArray = array_map($this->getTransformAsCallable(), $anObject);
    }

}
