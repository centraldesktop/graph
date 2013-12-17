<?php

$autoload_path =  __DIR__ . "/../vendor/autoload.php";
$loader = require($autoload_path);

$loader->add('CentralDesktop\Graph\Test', __DIR__ . DIRECTORY_SEPARATOR . 'src');