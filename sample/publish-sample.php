<?php

require_once __DIR__ . '/vendor/autoload.php';

use ResponseJson\ResponseJson;

$responseJson = new ResponseJson();

$helper = $responseJson->responseDelete();

print_r($helper);
