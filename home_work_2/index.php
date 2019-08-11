<?php

class RandomArray
{
    public $array;
    public $count;
    public $interval;

    public function __construct($count = 30, $interval = [0, 100])
    {
        $this->count = $count ?: $this->count;
        $this->interval = $interval ?: $interval;
        $this->array = $this->getRandomArray();
    }

    /**
     * получить массив случайных чисел
     * @return array
     */
    function getRandomArray()
    {
        $arr = [];
        for ($i = 0; $i < $this->count; $i++) {
            $arr[] = rand($this->interval[0], $this->interval[1]);
        }
        return $arr;
    }

    /**
     * отображение массива в виде таблицы
     * @param int $tableColumns
     */
    function renderArray($tableColumns = 10)
    {
        $htmlText = '<table><tr>';
        foreach ($this->array as $key => $value) {
            $htmlText .= '<td style="border: 1px solid #000; background-color: #ccc;">' .
                $key . '</td>' . '<td style="border: 1px solid #000; background-color: #f5f5f5;">' .
                $value . '</td>' . '<td></td>';
            if (!(($key + 1) % $tableColumns)) {
                $htmlText .= '</tr><tr>';
            }
        }
        $htmlText .= '</tr></table>';
        echo $htmlText;
    }

    /**
     * получение случайного элемента (для дальнейшей доработки)
     * @param $arr
     * @return mixed
     */
    function getRandomElement($arr)
    {
        $randIdx = rand(0, count($arr) - 1);
        return $arr[$randIdx];
    }

    /**
     * быстрая сортировка
     * @param $arr
     * @param $iters
     * @return array
     */
    function quickSort(&$arr, &$iters)
    {
        $count = count($arr);
        if ($count < 2) {
            return $arr;
        }
        $baseElem = $this->getRandomElement($arr);
        $left = [];
        $right = [];
        for ($i = 1; $i < $count; $i++) {
            $iters++;
            if ($arr[$i] <= $baseElem) {
                $left[] = $arr[$i];
            } else {
                $right[] = $arr[$i];
            }
        }

        $left = $this->quickSort($left, $iters);
        $right = $this->quickSort($right, $iters);

        return array_merge($left, [$baseElem], $right);
    }

    /**
     * клонирование массива
     * @param $arr
     * @return array
     */
    function getClone(&$arr)
    {
        $obj = new ArrayObject($arr);
        return $obj->getArrayCopy();
    }

    /**
     * сортировка слиянием
     * @param array $arr
     * @param $iters
     * @return array
     */
    function mergeSort(array $arr, &$iters)
    {
        $count = count($arr);
        if ($count <= 1) {
            return $arr;
        }

        $left = array_slice($arr, 0, (int)($count / 2));
        $right = array_slice($arr, (int)($count / 2));

        $left = $this->mergeSort($left, $iters);
        $right = $this->mergeSort($right, $iters);

        return $this->merge($left, $right, $iters);
    }

    /**
     * часть сортировки слиянием - само слияние частей
     * @param array $left
     * @param array $right
     * @param $iters
     * @return array
     */
    function merge(array $left, array $right, &$iters)
    {
        $result = [];
        while (count($left) > 0 && count($right) > 0) {
            $iters++;
            if ($left[0] < $right[0]) {
                array_push($result, array_shift($left));
            } else {
                array_push($result, array_shift($right));
            }
        }
        $iters++;
        array_splice($result, count($result), 0, $left);
        array_splice($result, count($result), 0, $right);

        return $result;
    }
}

$count = 100;
$arr = new RandomArray($count);
$arr->renderArray(10);
$iters = 0;
$timeStart = microtime();
//$arr->array = $arr->quickSort($arr->array, $iters);
$arr->mergeSort($arr->array, $iters);
$timeStop = microtime();
echo 'Затраченное время: ' . ($timeStop - $timeStart) . '<br>';
echo 'Количество элементов: ' . $count . '<br>';
echo 'Количество итераций: ' . $iters . '<br>';
$arr->renderArray(10);

