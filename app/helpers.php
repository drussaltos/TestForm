<?php

use App\Services\Database;
use App\Services\Roles;
use Delight\Auth\Auth;
use JasonGrimes\Paginator;

function view($path, $parameters = [])
{
    global $container;
    $plates = $container->get('plates');
    echo $plates->render($path, $parameters);
}

function back()
{
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

function redirect($path)
{
    header("Location: $path");
    exit;
}

function config($field)
{
    $config = require '../app/config.php';
    return array_get($config, $field);
}