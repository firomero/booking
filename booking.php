<?php
/**
 * Customized Booking functions  and configurations
 * @package Booking
 * @author firomero<firomerorom4@gmail.com>
 */

/**
 * Array unique callback
 * @param array $arr
 * @param callable $callback
 * @param bool $strict
 * @return array
 */
function array_unique_callback(array $arr, callable $callback, $strict = false)
{
    return array_filter(
        $arr,
        function ($item) use ($strict, $callback) {
            static $haystack = array();
            $needle = $callback($item);
            if (in_array($needle, $haystack, $strict)) {
                return false;
            } else {
                $haystack[] = $needle;
                return true;
            }
        }
    );
}

/**
 * Array unique in object
 * @param $obj
 * @return mixed
 */
function object_unique($obj)
{
    $objArray = (array)$obj;

    $objArray = array_intersect_assoc(array_unique($objArray), $objArray);

    foreach ($obj as $n => $f) {
        if (!array_key_exists($n, $objArray)) unset($obj->$n);
    }

    return $obj;
}

/**
 * The QuickSort Method
 * @param array $array
 * @param callable $callback
 * @return array
 */
function quicksort_callback(array $array,callable $callback)
{
    if (count($array) < 2) {
        return $array;
    }
    $left = $right = array();
    reset($array);
    $pivot_key = key($array);
    $pivot = array_shift($array);
    foreach ($array as $k => $v) {
        if ($callback($v) > $callback($pivot)) {
            $left[$k] = $v;
        } else {
            $right[$k] = $v;
        }
    }

    return array_merge(quicksort_callback($left, $callback), array($pivot_key => $pivot), quicksort_callback($right, $callback));
}

/**
 * The BubbleSort Method
 * @param $array
 */
function bubbleSortByTipoHab(&$array)
{
    if (!$length = count($array)) {
        return $array;
    }
    for ($outer = 0; $outer < $length; $outer++) {
        for ($inner = 0; $inner < $length; $inner++) {
            if (($array[$inner]->getPeso() > $array[$outer]->getPeso())
            ) {
                $tmp = $array[$outer];
                $array[$outer] = $array[$inner];
                $array[$inner] = $tmp;
            }
        }
    }
}

/**
 * Binary Search Uncentered
 * This is the method of binary search calculating the exact pivote for the search.
 * @param array $haystack
 * @param $first
 * @param $last
 * @param $needle
 * @return bool
 */
function binary_search_uncentered(array $haystack, $first, $last,$needle){

    $nterc = round(sizeof($haystack)/3);

    if ($first>=$last) {
        if ($haystack[$last]==$needle) {
            return true;
        } else {
            return false;
        }
    }

    $nterc = round(($last-$first+1)/3);
    if ($needle==$haystack[$first+$nterc]) {
        return true;
    }elseif($needle<$haystack[$first+$nterc]){
        return binary_search_uncentered($haystack,$first,$first+$nterc-1,$needle);

    } elseif ($needle==$haystack[$last-$nterc]) {
        return true;
    } elseif ($needle<$haystack[$last-$nterc]) {
        return binary_search_uncentered($haystack,$first+$nterc+1,$last-$nterc-1,$needle);
    } else {
        return binary_search_uncentered($haystack,$last-$nterc+1,$last,$needle);
    }

    return false;


}

/**
 * Binary Search Uncentered with Callback
 * This is the method of binary search calculating the exact pivote for the search.
 * @param array $haystack
 * @param $first
 * @param $last
 * @param $needle
 * @param callable $callback
 * @return bool
 */
function binary_search_uncentered_callable(array $haystack, $first, $last,$needle, callable $callback){

    $nterc = round(sizeof($haystack)/3);

    if ($first>=$last) {
        if ($callback($haystack[$last])==$callback($needle)) {
            return $last;
        } else {
            return -1;
        }
    }

    $nterc = round(($last-$first+1)/3);
    if ($callback($needle)==$callback($haystack[$first+$nterc])) {
        return $first+$nterc;
    }elseif($callback($needle)<$callback($haystack[$first+$nterc])){
        return binary_search_uncentered($haystack,$first,$first+$nterc-1,$needle);

    } elseif ($callback($needle)==$callback($haystack[$last-$nterc])) {
        return $last-$nterc;
    } elseif ($callback($needle)<$callback($haystack[$last-$nterc])) {
        return binary_search_uncentered($haystack,$first+$nterc+1,$last-$nterc-1,$needle);
    } else {
        return binary_search_uncentered($haystack,$last-$nterc+1,$last,$needle);
    }

    return false;


}

/**
 * QuickSort de PHP
 * @param $array
 * @param string $field
 * @param string $direction
 * @return bool
 */
function sortBy(&$array,$field = 'value', $direction = 'asc')
{


    usort($array, function ($a, $b) use ($direction, $field) {


        if ($a[$field] == $b[$field]) {
            return 0;
        }

        return $direction == 'asc' ? ($a[$field] > $b[$field] ? -1 : 1) : ($a[$field] < $b[$field] ? -1 : 1);
    });

    return true;
}

/**
 * Maximum array number divider
 * @param array $collection
 * @return int|mixed
 */
function array_mcd(array $collection){
    if (count($collection)==0) {
        return 1;
    }
    elseif(count($collection)==1){
        return current($collection);
    }
    else{
        return array_reduce(array_map(function($item){
            return $item['value'];
        },$collection),function($a,$b){
            while (($a % $b) != 0) {
                $c = $b;
                $b = $a % $b;
                $a = $c;
            }
            return $b;
        });
    }


}

/**
 * Returns mcd single
 * @param $a
 * @param $b
 * @return mixed
 */
function _mcd($a,$b){
    while (($a % $b) != 0) {
        $c = $b;
        $b = $a % $b;
        $a = $c;
    }
    return $b;
}

/**
 * Returns mcm(minimum common multiple) from a collection
 * @param array $collection
 * @return int|mixed
 */
function array_mcm(array $collection){
    if (count($collection)==0) {
        return 1;
    } elseif (count($collection)==1) {
        return current($collection);
    } else {

        return array_reduce(array_map(function($item){return $item['value'];},$collection),function($a,$b){
            return ($a * $b) / _mcd($a,$b);
        });
    }
}

/**
 * Generate the average collection with option callback
 * @param array $collection
 * @param callable $callback
 * @return float
 */
function average_callback(array $collection,callable $callback){
    $a =  array_reduce($collection,function($ac,$v)use($callback){
        $ac +=$callback($v);
        return $ac;
    });

    return $a/count($a);
}

/**
 * @param array $collection
 * @param int $am
 * @param callable $predicate
 * @return array
 */
function array_mt_rand(array $collection,$am = 1){
//    $dataResult = array();
    $final = array();
    $tmp = $collection;


    $count = $am;
    if ($count>count($collection)) {
        $count = count($collection);
    }
    if ($count>1) {
        while($count>0){
            $key = mt_rand(0,--$count);
            $final [] = $tmp[$key];
            unset($tmp[$key]);
            $tmp = array_values($tmp);
        }
    }
    else{


        $final = $tmp;

    }

    return $final;
}

/**
 * Unorder an array
 * @param array $array
 * @return array
 */
function array_shuffle(array $array){
   $copy = $array;
    uasort($copy, function ($a, $b) {
        return mt_rand(-1, 1);
    });

    return $copy;

}


/**
 * Inserts a value in a array
 * @param $array
 * @param $value
 * @param $index
 * @return array
 */
function array_insert($array, $value, $index)
{
    $copy = $array;
    return $copy = array_merge(array_splice($copy, max(0, $index - 1)), array($value), $copy);
}



