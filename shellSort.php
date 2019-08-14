<?php

function shellSort($elements, &$iters)
{
    $k = 0;
    $length = count($elements);
    $gap[0] = (int)($length / 2);

    while ($gap[$k] > 1) {
        $k++;
        $gap[$k] = (int)($gap[$k - 1] / 2);
    }

    for ($i = 0; $i <= $k; $i++) {
        $step = $gap[$i];

        for ($j = $step; $j < $length; $j++) {
            $temp = $elements[$j];
            $p = $j - $step;

            while ($p >= 0 && $temp['price'] < $elements[$p]['price']) {
                $iters++;
                $elements[$p + $step] = $elements[$p];
                $p = $p - $step;
            }

            $elements[$p + $step] = $temp;
        }
    }

    return $elements;
}

function getRandomPrices($count)
{
    $arr = [];
    for ($i = 0; $i < $count; $i++) {
        $arr[] = [
            'price' => rand(10000, 40000),
            'shop_name' => 'Shop ' . rand(1, 4)
        ];
    }
    return $arr;
}

$prices = [
    [
        'price' => 21999,
        'shop_name' => 'Shop 1',
        'shop_link' => 'http://'
    ],
    [
        'price' => 21550,
        'shop_name' => 'Shop 2',
        'shop_link' => 'http://'
    ],
    [
        'price' => 21950,
        'shop_name' => 'Shop 2',
        'shop_link' => 'http://'
    ],
    [
        'price' => 21350,
        'shop_name' => 'Shop 2',
        'shop_link' => 'http://'
    ],
    [
        'price' => 21050,
        'shop_name' => 'Shop 2',
        'shop_link' => 'http://'
    ]
];

$countElems = 20000;
$arrFirst = getRandomPrices($countElems);
$iters = 0;
$startTime = microtime();
$arrSecond = shellSort($arrFirst, $iters);
$endTime = microtime();
echo 'количество элементов (n): ' . $countElems . '<br>';
echo 'количество итераций сортировки: ' . $iters . '<br>';
$limUp = $countElems * $countElems;
$limDown = $countElems * log($countElems, 2);
$percentUp = ($limUp - $iters) / ($limUp - $limDown) * 100;
$percentDown = ($iters - $limDown) / ($limUp - $limDown) * 100;
$percentUp = floor($percentUp*1000)/1000;
$percentDown = floor($percentDown*1000)/1000;
echo 'n^2 = ' . $limUp . '<br>';
echo 'n*log2(n) = ' . $limDown . '<br>';
if (($limUp - $iters) < ($iters - $limDown)) {
    echo 'отстает (ближе) от нижней границе на ' . $percentUp . ' % от интервала [верх-низ]';
} else {
    echo 'отстает (ближе) от верхней границе на ' . $percentDown . ' % от интервала [верх-низ]';
}
echo '<br>';
echo 'время выполнения сортировки: ' . ($endTime - $startTime) . '<br>';




