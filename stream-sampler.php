<?php

require 'vendor/autoload.php';

use VarunAgw\StreamSampler;

// Validate command line argument
if (!isset($argv[1])) {
    die('Size of sample data missing');
} elseif (!is_numeric($argv[1]) || (int) $argv[1] <= 0) {
    die('Invalid size of sample data');
} else {
    $size = (int) $argv[1];
}

$streamSampler = new StreamSampler\StreamSampler(STDIN, $size);
$randomCharacters = $streamSampler->getRandomCharacters();

printf('%d random characters from input are %s', $size, implode($randomCharacters));

