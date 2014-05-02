<?php

// Include the router class
require_once( __DIR__ . DIRECTORY_SEPARATOR . 'router.php' );

// Create a new router
$router = new Router();

// Route the request
$router->route();

