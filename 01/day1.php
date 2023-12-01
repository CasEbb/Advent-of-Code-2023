<?php

$fh = fopen("input", "r");

$calibrationValues = ['A' => [], 'B' => []];

function them_digits($line) {
    $digits = [];

    foreach (str_split($line) as $char) {
        if (ctype_digit($char)) {
            $digits[] = (int)$char;
        }
    }

    return reset($digits) . end($digits);
}

while($line = fgets($fh)) {
    $calibrationValues['A'][] = them_digits($line);

    $line = str_replace([
        'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine',
    ], [
        'o1e', 't2o', 't3e', 'f4r', 'f5e', 's6x', 's7n', 'e8t', 'n9e',
    ], $line);

    $calibrationValues['B'][] = them_digits($line);
}

echo array_sum($calibrationValues['A']);
echo " ";
echo array_sum($calibrationValues['B']);
echo PHP_EOL;
