<?php

class Request
{
    public $path;

    public function __construct($path)
    {
        if ($_GET['path']) {
            $this->path = $path . $_GET['path'];
        }
        if ($this->isLevelUp()) {
            $this->path = $this->getLevelUp();
        }
    }

    function isLevelUp()
    {
        $path = $this->path;
        return mb_substr($path, mb_strlen($path) - 2, 2) == '..';
    }

    function getLevelUp()
    {
        preg_match_all('/\//',
            $this->path,
            $mathes,
            PREG_OFFSET_CAPTURE);
        $count = count($mathes[0]);
        $pos = $mathes[0][$count - 2][1] + 1;
        return substr($this->path, 0, $pos);
    }

}
