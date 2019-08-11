<?php

class TemplateRender
{
    function render($template, $params)
    {
        ob_start();
        extract($params);
        include $_SERVER['DOCUMENT_ROOT'] . '/services/views/' . $template . '.php';
        return ob_get_clean();
    }
}