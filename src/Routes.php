<?php

/**
 * Home
 */
$router->get('/', '\Responsible\Api\Components\Home\Controllers\Home::index');

/**
 * Articles (plural)
 */
$router->get('/articles', '\Responsible\Api\Components\Articles\Controllers\Articles::index');

/**
 * Articles (singular)
 */
$router->get('/article/{id}', '\Responsible\Api\Components\Articles\Controllers\Articles::show');
