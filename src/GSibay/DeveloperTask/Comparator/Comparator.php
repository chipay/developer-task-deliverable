<?php

namespace GSibay\DeveloperTask\Comparator;

/**
 * A comparator that provides a function to compare
 * two objects
 *
 * @author gsibay
 *
 */
interface Comparator
{
    /**
     * Compares two objects.
     * Returns a positive number if $anObject > $anotherObject,
     * a negative number if $anObject < $anotherObject,
     * and 0 otherwise (i.e. they are equals).
     *
     * @param $anObject The object where the predicate is applied
     * @returns boolean The result of evaluating the predicate
     */
    public function compareTo($anObject, $anotherObject);
}
