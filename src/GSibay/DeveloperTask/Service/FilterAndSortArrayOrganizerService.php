<?php

namespace GSibay\DeveloperTask\Service;

use GSibay\DeveloperTask\Predicate\Predicate;
use GSibay\DeveloperTask\Comparator\Comparator;

/**
 * Organize an array of objects using a predicate (optional) and a comparator (optional).
 * If the predicate is present then the array is filtered according to that predicate.
 * If the comparator is provided then the array is sorted using that comparator.
 *
 * @author gsibay
 *
 */
class FilterAndSortArrayOrganizerService implements ArrayOrganizerService
{

    /**
     * The predicate to filter the array.
     * @var Predicate
     */
    private $filterPredicate;

    /**
     * The comparator used to sort the array.
     * @var Comparator
     */
    private $comparator;

    /**
     * @param  Comparator $comparator      The comparator used to sort the array.
     * @param  Predicate  $filterPredicate The predicat used to filter the array.
     * @return array:
     */
    public function __construct(Predicate $filterPredicate = null, Comparator $comparator = null)
    {
        $this->filterPredicate = $filterPredicate;
        $this->comparator = $comparator;
    }

    /**
     * Filter the array using the predicate (if present).
     * If there is no filter then the original array is returned.
     * @param  array $array The array to filter.
     * @return array The filtered array.
     */
    private function filter($array)
    {
        // filter the array using the predicate (if present)
        $filterPredicate = $this->filterPredicate;
        if ($filterPredicate === null) {
            return $array;
        } else {
            return array_filter($array,
                        function ($anObject) use ($filterPredicate) {
                            return $filterPredicate->evaluate($anObject);
                        });
        }
    }

    /**
     * Sorts the array with the comparator (if present). If not
     * the array is left unchanged.
     * @param array $array The array to be sort.
     */
    private function sort(&$array)
    {
        if ($this->comparator !== null) {
            usort($array, array($this->comparator, 'compareTo'));
        }
    }

    /**
     * (non-PHPdoc)
     * @see GSibay\DeveloperTask\Service.ArrayOrganizerService::organize()
     */
    public function organize(array $array)
    {
        $organizedArray = $this->filter($array);
        $this->sort($organizedArray);

        return $organizedArray;
    }

}
