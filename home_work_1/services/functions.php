<?php

function getLevelUp($path)
{
    preg_match_all('/\//',
        $path,
        $mathes,
        PREG_OFFSET_CAPTURE);
    $count = count($mathes[0]);
    $pos = $mathes[0][$count - 2][1] + 1;
    $result = substr($path, 0, $pos);
    return $result;
}

function isRootPath($path)
{
    return strcmp($path, PATH_ROOT . '/') == 0;
}