<?php

require_once('./vendor/autoload.php');

$client = new \Candio\CoreClient\CoreClient('http://candio-core:8080/');
$result = $client->getConfigById("1");

var_dump($result);
