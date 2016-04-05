<?php

use Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = new Dotenv(dirname(__DIR__));
$dotenv->load();

