<?php

include __DIR__ . '/model/Catalog.php';
include __DIR__ . '/services/TemplateRender.php';
include __DIR__ . '/services/Request.php';
include __DIR__ . '/services/functions.php';

define('PATH_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('PATH_DEFAULT', $_SERVER['DOCUMENT_ROOT'] . '/new/');
define('IMAGES_DIR', 'public/images/');

if (isset($path) == null) {
    $path = PATH_DEFAULT;
    session_start();
    $_SESSION['path'] = $path;
}
if (isset($_GET['path'])) {
    if ($_GET['path'] == '..') {
        $_SESSION['path'] = getLevelUp($_SESSION['path']);
        var_dump($_SESSION['path']);
    } else {
        var_dump($_SESSION['path']);
        $_SESSION['path'] .= $_GET['path'];
        var_dump($_SESSION['path']);
//        var_dump($_GET['path']);
    }
}
if ($_SESSION['session']) {
    if ($_SESSION['session'] == 'clear') {
        session_destroy();
        unset($path);
        header('location: index.php');
    }
}

$folder = (new Catalog($_SESSION['path']))->explore();
$params = [
    'picFolder' => 'public/images/folder.png',
    'folder' => $folder,
    'currentPath' => $_SESSION['path']
];

echo (new TemplateRender())->render('main', $params);
