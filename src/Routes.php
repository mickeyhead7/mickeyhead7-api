<?php

/**
 * Home
 */
$router->get('/', '\Responsible\Responsible\Api\Components\Home\Controllers\Home::index');

/**
 * Articles (plural)
 */
$router->get('/articles', '\Responsible\Responsible\Api\Components\Articles\Controllers\Articles::index');

/**
 * Articles (singular)
 */
$router->get('/article/{id}', '\Responsible\Responsible\Api\Components\Articles\Controllers\Articles::show');
