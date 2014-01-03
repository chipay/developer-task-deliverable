<?php

namespace GSibay\DeveloperTask\Comparator;

/**
 * Uses the natural comparison of the objects.
 * It can be set to ascending or descending
 * depending on the boolean set during construction.
 *
 *
 * @author gsibay
 *
 */
class NaturalOrderComparator implements Comparator
{
    private $ascendingOrder;

    /**
     * Creates a natural order comparator.
     * @param boolean $ascending True to use ascending order, false to use descending order
     */
    public function __construct($ascending = true)
    {
        $this->ascendingOrder = $ascending;
    }

    /**
     * (non-PHPdoc)
     * @see GSibay\DeveloperTask\Comparator.Comparator::compareTo()
     */
    public function compareTo($anObject, $anotherObject)
    {
        if ($anObject == $anotherObject) {
            return 0;
        }

        $naturalOrderCompareTo = $anObject > $anotherObject ? 1 : -1;

        return $this->ascendingOrder ? $naturalOrderCompareTo : -$naturalOrderCompareTo;
    }
}
