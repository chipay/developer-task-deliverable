<?php

namespace GSibay\DeveloperTask\Predicate;

/**
 * A predicate that applies to \DateTime objects with year
 * from 0 up to 2203. If the year is bigger than 2203 the predicate
 * will not be evaluated and throw an exception instead.
 * It evaluates to true if the year in the date is
 * a composite number (i.e. it is not a prime number).
 *
 * @author gsibay
 *
 */
class IsYearCompositeNumber implements Predicate
{
    //XXX php does not allow arrays as constant. Using a private attribute instead
    // list of primes from http://primes.utm.edu/lists/small/10000.txt
    private $primeYearsUpTo2203 = array(
            2 => true,       3 => true,       5 => true,       7 => true,      11 => true,      13 => true,      17 => true,      19 => true,      23 => true,      29 => true,
            31 => true,      37 => true,      41 => true,      43 => true,      47 => true,      53 => true,      59 => true,      61 => true,      67 => true,      71 => true,
            73 => true,      79 => true,      83 => true,      89 => true,      97 => true,     101 => true,     103 => true,     107 => true,     109 => true,     113 => true,
            127 => true,     131 => true,     137 => true,     139 => true,     149 => true,     151 => true,     157 => true,     163 => true,     167 => true,     173 => true,
            179 => true,     181 => true,     191 => true,     193 => true,     197 => true,     199 => true,     211 => true,     223 => true,     227 => true,     229 => true,
            233 => true,     239 => true,     241 => true,     251 => true,     257 => true,     263 => true,     269 => true,     271 => true,     277 => true,     281 => true,
            283 => true,     293 => true,     307 => true,     311 => true,     313 => true,     317 => true,     331 => true,     337 => true,     347 => true,     349 => true,
            353 => true,     359 => true,     367 => true,     373 => true,     379 => true,     383 => true,     389 => true,     397 => true,     401 => true,     409 => true,
            419 => true,     421 => true,     431 => true,     433 => true,     439 => true,     443 => true,     449 => true,     457 => true,     461 => true,     463 => true,
            467 => true,     479 => true,     487 => true,     491 => true,     499 => true,     503 => true,     509 => true,     521 => true,     523 => true,     541 => true,
            547 => true,     557 => true,     563 => true,     569 => true,     571 => true,     577 => true,     587 => true,     593 => true,     599 => true,     601 => true,
            607 => true,     613 => true,     617 => true,     619 => true,     631 => true,     641 => true,     643 => true,     647 => true,     653 => true,     659 => true,
            661 => true,     673 => true,     677 => true,     683 => true,     691 => true,     701 => true,     709 => true,     719 => true,     727 => true,     733 => true,
            739 => true,     743 => true,     751 => true,     757 => true,     761 => true,     769 => true,     773 => true,     787 => true,     797 => true,     809 => true,
            811 => true,     821 => true,     823 => true,     827 => true,     829 => true,     839 => true,     853 => true,     857 => true,     859 => true,     863 => true,
            877 => true,     881 => true,     883 => true,     887 => true,     907 => true,     911 => true,     919 => true,     929 => true,     937 => true,     941 => true,
            947 => true,     953 => true,     967 => true,     971 => true,     977 => true,     983 => true,     991 => true,     997 => true,    1009 => true,    1013 => true,
            1019 => true,    1021 => true,    1031 => true,    1033 => true,    1039 => true,    1049 => true,    1051 => true,    1061 => true,    1063 => true,    1069 => true,
            1087 => true,    1091 => true,    1093 => true,    1097 => true,    1103 => true,    1109 => true,    1117 => true,    1123 => true,    1129 => true,    1151 => true,
            1153 => true,    1163 => true,    1171 => true,    1181 => true,    1187 => true,    1193 => true,    1201 => true,    1213 => true,    1217 => true,    1223 => true,
            1229 => true,    1231 => true,    1237 => true,    1249 => true,    1259 => true,    1277 => true,    1279 => true,    1283 => true,    1289 => true,    1291 => true,
            1297 => true,    1301 => true,    1303 => true,    1307 => true,    1319 => true,    1321 => true,    1327 => true,    1361 => true,    1367 => true,    1373 => true,
            1381 => true,    1399 => true,    1409 => true,    1423 => true,    1427 => true,    1429 => true,    1433 => true,    1439 => true,    1447 => true,    1451 => true,
            1453 => true,    1459 => true,    1471 => true,    1481 => true,    1483 => true,    1487 => true,    1489 => true,    1493 => true,    1499 => true,    1511 => true,
            1523 => true,    1531 => true,    1543 => true,    1549 => true,    1553 => true,    1559 => true,    1567 => true,    1571 => true,    1579 => true,    1583 => true,
            1597 => true,    1601 => true,    1607 => true,    1609 => true,    1613 => true,    1619 => true,    1621 => true,    1627 => true,    1637 => true,    1657 => true,
            1663 => true,    1667 => true,    1669 => true,    1693 => true,    1697 => true,    1699 => true,    1709 => true,    1721 => true,    1723 => true,    1733 => true,
            1741 => true,    1747 => true,    1753 => true,    1759 => true,    1777 => true,    1783 => true,    1787 => true,    1789 => true,    1801 => true,    1811 => true,
            1823 => true,    1831 => true,    1847 => true,    1861 => true,    1867 => true,    1871 => true,    1873 => true,    1877 => true,    1879 => true,    1889 => true,
            1901 => true,    1907 => true,    1913 => true,    1931 => true,    1933 => true,    1949 => true,    1951 => true,    1973 => true,    1979 => true,    1987 => true,
            1993 => true,    1997 => true,    1999 => true,    2003 => true,    2011 => true,    2017 => true,    2027 => true,    2029 => true,    2039 => true,    2053 => true,
            2063 => true,    2069 => true,    2081 => true,    2083 => true,    2087 => true,    2089 => true,    2099 => true,    2111 => true,    2113 => true,    2129 => true,
            2131 => true,    2137 => true,    2141 => true,    2143 => true,    2153 => true,    2161 => true,    2179 => true,    2203 => true
            );

    /**
     * (non-PHPdoc)
     * @see GSibay\DeveloperTask\Prediate.Predicate::evaluate()
     */
    public function evaluate($date)
    {
        $year =$date->format('Y');

        if ($year < 0 || $year > 2203) {
            throw new \UnexpectedValueException("Date's year is not in the exptected range: [0..2203]. Date provided was (d-m-Y): " . $date->format('d-m-Y'));
        }

        return !array_key_exists($year, $this->primeYearsUpTo2203);
    }
}
