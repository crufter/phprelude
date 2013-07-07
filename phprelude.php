<?php

/*
* PHPrelude, the PHP port of the Haskell Prelude.
* For fun and profit.
*/

interface EQ {
    // returns a Bool
    public function eq($b);
}

interface Ord {
    // returns a Bool
    public function lessOrEq($b);
}

//
// Misc functions
//

/*
* Identity function.
*
* @param mixed $a
* @return mixed
*/
function id($a) {
    return $a;
}

/*
* Constant function.
* const in Haskell.
*
* @param mixed $a
* @param mixed $b
* @return mixed
*/
function con($a, $b) {
    return $a;
}

/*
* Function composition.
* (.) in Haskell.
*
* @param function $f1
* @param function $f2
* @return function
*/
function dot($f1, $f2) {
    return function($a) use ($f1, $f2) {
        return $f1($f2($a));
    };
}

/*
* flip($f) takes its two arguments in the reverse order of $f.
*
* @param function $f
* @return function
*/
function flip($f) {
    return function($a, $b) use ($f) {
        return $f($b, $a);
    };
}

//
// Awesome list (array in case of PHP) operations
//

/*
* map f xs is the list obtained by applying f to each element of xs
*
* @param function $f function to map with
* @param array $xs list to map over
* @return array
*/
function map($f, $xs) {
    $ys = array();
    foreach ($xs as $x) {
        $ys[] = $f($x);
    }
    return $ys;
} 

/*
* (++) in Haskell, concatenates two lists
*
* @param array $xs first list
* @param array $ys second list
* @return array
*/
function pp($xs, $ys) {
    return array_merge($xs, $ys);
}

/*
* filter, applied to a predicate and a list, returns the list of those elements that satisfy the predicate
*
* @param function $pred predicate
* @param array $xs list to filter
* @return array
*/
function filter($pred, $xs) {
    $ys = array();
    foreach($xs as $x) {
        if ($pred($x) === true) {
            $ys[] = $x;
        }
    }
    return $ys;
}

/*
* Extract the first element of a list, which must be non-empty.
*
* @param array $xs
* @return mixed
*/
function head($xs) {
    if (count($xs) === 0) {
        throw new Exception('Prelude.head: empty list');
    }
    return $xs[0];
}

/*
* Extract the elements after the {@link head()} of a list, which must be non-empty.
*
* @param array $xs
* @return mixed
*/
function last($xs) {
    if (count($xs) === 0) {
        throw new Exception('Prelude.last: empty list');
    }
    $last = end($xs);
    reset($xs);
    return $last;
}

/*
* Extract the elements after the {@link head()} of a list, which must be non-empty.
*
* @param array $xs
* @return array
*/
function tail($xs) {
    if (count($xs) === 0) {
        throw new Exception('Prelude.tail: empty list');
    }
    return array_slice($xs, 1);
}

/*
* Return all the elements of a list except the last one. The list must be non-empty.
*
* @param array $xs
* @return array
*/
function init($xs) {
    if (count($xs) === 0) {
        throw new Exception('Prelude.init: empty list');
    }
    return array_slice($xs, 0, -1);
}

/*
* Test whether a list is empty.
* null in Haskell.
*
* @param array $xs
* @return bool
*/
function nul($xs) {
    return count($xs) === 0;
}

/*
* length returns the length of a finite list
*
* @param array $xs
* @return int
*/
function length($xs) {
    return count($xs);
}

/*
* reverse($xs) returns the elements of xs in reverse order.
*
* @param array $xs
* @return array
*/
function reverse($xs) {
    return array_reverse($xs);
}

//
// Reducing lists (folds)
//

/*
* foldl, applied to a binary operator, a starting value (typically the left-identity of the operator),
* and a list, reduces the list using the binary operator, from left to right.
*
* @param function $f
* @param mixed $start starting value
* @param array $xs
* @return mixed
*
* <code>
* foldl($f, $z, [$x1, $x2, ..., $xn]) == $f($f($f($z, $x1), $x2), ...)
* </code>
*/
function foldl($f, $start, $xs) {
    foreach ($xs as $x) {
        $start = $f($start, $x);
    }
    return $start;
}

/*
* foldl1 is a variant of {@link foldl()} that has no starting value argument, and thus must be applied to non-empty lists.
*
* @param function $f
* @param array $xs
* @return mixed
*
* <code>
* 
* </code>
*/
function foldl1($f, $xs) {
    if (count($xs) === 0) {
        throw new Exception('Prelude.foldl1: empty list');
    }
    $last = head($xs);
    $iter = tail($xs);
    foreach ($iter as $val) {
        $last = $f($last, $val);
    }
    return $last;
}

// foldr, applied to a binary operator, a starting value (typically the right-identity of the operator),
// and a list, reduces the list using the binary operator, from right to left.
function foldr($f, $start, $xs) {
    return foldl($f, $start, reverse($xs));
}

// foldr1 is a variant of foldr that has no starting value argument, and thus must be applied to non-empty lists.
function foldr1($f, $xs) {
    if (count($xs) === 0) {
        throw new Exception('Prelude.foldr1: empty list');
    }
    return foldl1($f, reverse($xs));
}

//
// Special folds
//

// _and returns the conjunction of a Boolean list.
function _and($xs) {
    foreach($xs as $x) {
        if ($x === false) {
            return false;
        }
    }
    return true;
}

// _or returns the disjunction of a Boolean list.
function _or($xs) {
    foreach($xs as $x) {
        if ($x == true) {
            return true;
        }
    }
    return false;
}

// Applied to a predicate and a list, any determines if any element of the list satisfies the predicate.
function any($f, $xs) {
    foreach($xs as $x) {
        if ($f($x) === true) {
            return true;
        }
    }
    return false;
}

// Applied to a predicate and a list, all determines if all elements of the list satisfy the predicate.
function all($f, $xs) {
    foreach($xs as $x) {
        if ($f($x) === false) {
            return false;
        }
    }
    return true;
}

// The sum function computes the sum of a finite list of numbers.
function sum($xs) {
    return foldl(function($a, $b){
        return $a + $b;
    }, 0, $xs);
}

// The product function computes the product of a finite list of numbers.
function product($xs) {
    return foldl(function($a, $b) {
        return $a * $b;
    }, 1, $xs);
}

// Concatenate a list of lists.
function concat($xs) {
    return foldr(pp, array(), $xs);
}

// Map a function over a list and concatenate the results.
function concatMap($f, $xs) {
    return concat(map($f, $xs));
}

// maximum returns the maximum value from a list, which must be non-empty, finite, and of an ordered type
// (list members must implement the interface {@link Ord})
function maximum($xs) {
    if (count($xs) === 0) {
        throw new Exception('Prelude.maximum: empty list');
    }
    $max = head($xs);
    $iter = tail($xs);
    foreach ($iter as $x) {
        if ($max->lessOrEq($x)) {
            $max = $x;
        }
    }
    return $max;
}

/*
* minimum returns the minimum value from a list, which must be non-empty, finite, and of an ordered type.
* (list members must implement the interface {@link Ord})
*/
function minimum($xs) {
    if (count($xs) === 0) {
        throw new Exception('Prelude.maximum: empty list');
    }
    $min = head($xs);
    $iter = tail($xs);
    foreach ($iter as $x) {
        if ($x->lessOrEq($min)) {
            $min = $x;
        }
    }
    return $min;
}

//
// Building lists
//

/*
* scanl is similar to {@link foldl()}, but returns a list of successive reduced values from the left:
*
* @param $xs
*
* <code>
* scanl($f, $z, array($x1, $x2, ...)) == array($z, $f($z, $x1), $f($z, $x2), ...);
* </code>
*
* Note that:
*
* <code>
* last(scanl($f, $z, $xs)) == foldl($f, $z, $xs);
* </code>
*/ 
function scanl($f, $start, $xs) {
    $ret = array($start);
    foreach ($xs as $x) {
        $ret[] = $f($start, $x);
        $start = $x;
    }
    return $ret;
}

/*
* scanl1 is a variant of {@link scanl()} that has no starting value argument:
*
* <code>
* scanl1($f, array($x1, $x2, ...)) == array($x1, $f($x1, $x2), ...);
* </code>
*
* @param function $f
* @param array $xs
* @return array
*/
function scanl1($f, $xs) {
    if (count($xs) == 0) {
        return array();
    }
    return scanl($f, head($xs), tail($xs));
}

/*
* scanr is the right-to-left dual of scanl. Note that:
*
* <code>
* head(scanr($f, $z, $xs)) == foldr($f, $z, $xs);
* </code>
*
* @param function $f
* @param mixed $start
* @param array $xs
* @return array
*/
function scanr($f, $start, $xs) {
    return scanl($f, $start, reverse($xs));
}

/*
* scanr1 is a variant of scanr that has no starting value argument.
*
* @param function $f
* @param array $xs
* @return array
*/
function scanr1($f, $xs) {
    return scanl1($f, reverse($xs));
}

//
// Sublists
//

/*
* take $n, applied to a list $xs, returns the prefix of $xs of length $n, or xs itself if $n > length($xs):
* 
* <code>
* take(3, array(1,2,3,4,5)) == array(1,2,3);
* take(3, array(1,2)) == array(1, 2);
* take(3, array()) == array();
* take(-1, array(1,2)) == array();
* take(0, array(1,2)) == array();
* </code>
*
* @param int $n
* @param array $xs
* @return array
*/

function take($n, $xs) {
    if ($n <= 0) {
        return array();
    }
    if ($n > count($xs)) {
        $n = count($xs);
    }
    return array_slice($xs, 0, $n);
}

// more coming soon...

?>