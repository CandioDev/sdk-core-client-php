<?php

require_once('./vendor/autoload.php');

$client = new \Candio\CoreClient\CoreClient('http://candio-core:8080/', '1');
$result = $client->getConfig();

var_dump($result);
