<?php

namespace GSibay\DeveloperTask\Predicate;

/**
 * A predicate that can be evaluated on objects.
 *
 * @author gsibay
 *
 */
interface Predicate
{
    /**
     * Evaluates the predicate on $anObject
     * @param $anObject The object where the predicate is applied
     * @returns boolean The result of evaluating the predicate
     */
    public function evaluate($anObject);
}
