<?php

echo 'Задание 2<hr>';

$words[0] = 'палиндром';
$words[1] = 'а роза упала на лапу азора';
$words[2] = 'шалаш';

function palindrom($str, $index = 0)
{
    $arr = explode(" ", $str);
    $str = implode("", $arr);

    $count = mb_strlen($str);
    $middle = ($count % 2) ? floor($count / 2) + 1 : ($count / 2);
    if ($index >= $middle) {
        return true;
    }
    $symbLeft = mb_substr($str, $index, 1);
    $symbRight = mb_substr($str, $count - $index - 1, 1);
    if ($symbLeft == $symbRight) {
        return palindrom($str, $index + 1);
    } else {
        return false;
    }
}

foreach ($words as $word) {
    echo 'фраза: ' . $word . ' - палиндром:' . (int)palindrom($word) . '<br>';
}