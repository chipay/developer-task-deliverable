<?php

namespace GSibay\DeveloperTask\Predicate;

/**
 * A predicate that applies to \DateTime objects.
 * It evaluates to true if the year in the date is
 * a composite number (i.e. it is not a prime number).
 *
 * @author gsibay
 *
 */
class IsYearCompositeNumber implements Predicate
{
    /**
     * (non-PHPdoc)
     * @see GSibay\DeveloperTask\Prediate.Predicate::evaluate()
     */
    public function evaluate($anObject)
    {
        //TODO
        return true;
    }
}
