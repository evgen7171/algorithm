<?php

class SortClass
{
    public function getRandomElem($arr)
    {
        $index = rand(0, count($arr) - 1);
        return $arr[$index];
    }

    function quickSort(&$arr)
    {
        $count = count($arr);
        if ($count < 2) {
            return $arr;
        }
        $baseElem = $this->getRandomElem($arr);
        $left = [];
        $right = [];
        for ($i = 1; $i < $count; $i++) {
            if ($arr[$i] <= $baseElem) {
                $left[] = $arr[$i];
            } else {
                $right[] = $arr[$i];
            }
        }

        $left = $this->quickSort($left);
        $right = $this->quickSort($right);

        return array_merge($left, [$baseElem], $right);
    }

    function quickSortProperty(&$arr, $prop)
    {
        $count = count($arr);
        if ($count < 2) {
            return $arr;
        }
        $baseElem = $this->getRandomElem($arr);
        $left = [];
        $right = [];
        for ($i = 1; $i < $count; $i++) {
            if ($arr[$i][$prop] <= $baseElem[$prop]) {
                $left[] = $arr[$i];
            } else {
                $right[] = $arr[$i];
            }
        }

        $left = $this->quickSortProperty($left, $prop);
        $right = $this->quickSortProperty($right, $prop);

        return array_merge($left, [$baseElem], $right);
    }

    function getClone(&$arr)
    {
        $obj = new ArrayObject($arr);
        return $obj->getArrayCopy();
    }

    function mergeSort(array $arr)
    {
        $count = count($arr);
        if ($count <= 1) {
            return $arr;
        }

        $left = array_slice($arr, 0, (int)($count / 2));
        $right = array_slice($arr, (int)($count / 2));

        $left = $this->mergeSort($left);
        $right = $this->mergeSort($right);

        return $this->merge($left, $right);
    }

    function merge(array $left, array $right)
    {
        $result = [];
        while (count($left) > 0 && count($right) > 0) {
            if ($left[0] < $right[0]) {
                array_push($result, array_shift($left));
            } else {
                array_push($result, array_shift($right));
            }
        }
        array_splice($result, count($result), 0, $left);
        array_splice($result, count($result), 0, $right);

        return $result;
    }

    function mergeSortProperty(array $arr, $prop)
    {
        $count = count($arr);
        if ($count <= 1) {
            return $arr;
        }

        $left = array_slice($arr, 0, (int)($count / 2));
        $right = array_slice($arr, (int)($count / 2));

        $left = $this->mergeSortProperty($left, $prop);
        $right = $this->mergeSortProperty($right, $prop);

        return $this->mergeProperty($left, $right, $prop);
    }

    function mergeProperty(array $left, array $right, $prop)
    {
        $result = [];
        while (count($left) > 0 && count($right) > 0) {
            if ($left[0][$prop] < $right[0][$prop]) {
                array_push($result, array_shift($left));
            } else {
                array_push($result, array_shift($right));
            }
        }
        array_splice($result, count($result), 0, $left);
        array_splice($result, count($result), 0, $right);

        return $result;
    }
}