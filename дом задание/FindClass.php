<?php

class FindClass
{
    public function binarySearch($arr, $elem)
    {
        $left = 0;
        $right = count($arr) - 1;

        while ($left <= $right) {
            $middle = floor(($left + $right) / 2);

            if ($arr[$middle] == $elem) {
                return $middle;
            } elseif ($arr[$middle] > $elem) {
                $right = $middle - 1;
            } else {
                $left = $middle + 1;
            }
        }
        return 'элемент не найден';
    }

    public function binarySearch_recursive($arr, $elem)
    {
        return $this->binarySearch_rec($arr, $elem, 0, count($arr) - 1);
    }

    public function binarySearch_rec(array $arr, $elem, $left, $right)
    {
        if ($left > $right) {
            return 'Элемент не найден';
        }

        $middle = floor(($left + $right) / 2);

        if ($arr["$middle"] == $elem) {
            return $middle;
        } elseif ($arr["$middle"] > $elem) {
            return $this->binarySearch_rec($arr, $elem, $left, $middle - 1);
        } elseif ($arr["$middle"] < $elem) {
            return $this->binarySearch_rec($arr, $elem, $middle + 1, $right);
        }
    }

    public function binarySearchProperty_recursive($arr, $prop, $value)
    {
        return $this->binarySearchProperty_rec($arr, $prop, $value, 0, count($arr) - 1);
    }

    public function binarySearchProperty_rec(array $arr, $prop, $value, $left, $right)
    {
        if ($left > $right) {
            return 'Элемент не найден';
        }

        $middle = floor(($left + $right) / 2);

        if ($arr["$middle"][$prop] == $value) {
            return $middle;
        } elseif ($arr["$middle"][$prop] > $value) {
            return $this->binarySearchProperty_rec($arr, $prop, $value, $left, $middle - 1);
        } elseif ($arr["$middle"][$prop] < $value) {
            return $this->binarySearchProperty_rec($arr, $prop, $value, $middle + 1, $right);
        }
    }
}