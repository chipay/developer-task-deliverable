<?php

namespace GSibay\DeveloperTask\Arrays;

use GSibay\DeveloperTask\Comparator\Comparator;

use GSibay\DeveloperTask\Prediate\Predicate;

/**
 * Organize an array of objects using a predicate (optional) and a comparator (optional).
 * If the predicate is present then the array is filtered according to that predicate.
 * If the comparator is provided then the array is sorted using that comparator.
 *
 * @author gsibay
 *
 */
class ArrayOrganizer
{

    /**
     * Filters $anArray according to the predicate and sorts the array using the comparator.
     * If one of them is not provided then that step is not performed.
     * @param  array      $anArray         Array to be organized
     * @param  Comparator $comparator      The comparator used to sort the array
     * @param  Predicate  $filterPredicate The predicat used to filter the array
     * @return array:
     */
    public function organize(array $anArray, Comparator $comparator = null, Predicate $filterPredicate = null)
    {
        // filter the array using the predicate (if present)
        if ($filterPredicate === null) {
            $filteredArray = &$anArray;
        } else {
            $filteredArray = array_filter($anArray,
                    function ($anObject) use ($filterPredicate) {
                return $filterPredicate->evaluate($anObject);
            });
        }

        // sort the filtered array using the comparator (if present)
        if ($comparator !== null) {
            usort(filteredArray, array($comparator, 'compareTo'));
        }

        return $filteredArray;
    }
}
