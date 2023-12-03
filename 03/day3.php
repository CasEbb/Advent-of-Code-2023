<?php

function checkLine($lines)
{
    $results = [];

    foreach ($lines as $line) {
        $numbers = getNumbersOfLine($line);
        $results = array_merge($results, $numbers);
    }

    return array_filter($results, 'is_numeric');
}

function getNumbersOfLine($line)
{
    $results = [];

    $offset = 0;
    while ($index = strpos($line, '*', $offset)) {
        $numbers = array_merge(
            getNumbersAtPosition($line, $index - 1),
            getNumbersAtPosition($line, $index + 1)
        );

        if (count($numbers) === 2) {
            $results[] = $numbers[0] * $numbers[1];
        }

        $offset = $index + 1;
    }

    return $results;
}

function getNumbersAtPosition($line, $offset)
{
    if (!is_numeric($line[$offset])) {
        return [];
    }

    $left = getNumberAtValue($line, $offset - 1);
    $right = getNumberAtValue($line, $offset + 1);

    return array_filter([$left, $right], 'is_numeric');
}

function getNumberAtValue($line, $offset)
{
    if (
        $offset < 0 ||
        $offset >= strlen($line) ||
        !is_numeric($line[$offset])
    ) {
        return null;
    }

    $left = $offset;
    $right = $offset;

    while ($left >= 0 && is_numeric($line[$left])) {
        --$left;
    }

    while ($right < strlen($line) && is_numeric($line[$right])) {
        ++$right;
    }

    ++$left;
    --$right;

    return intval(substr($line, $left, $right - $left + 1));
}

$file = fopen("input", 'r');

$lineMin2 = null;
$lineMin1 = null;
$sum = 0;

while (($line = fgets($file)) !== false || $lineMin1 !== null) {
    $line = $line !== false ? trim($line) : null;

    if ($lineMin1 !== null && strlen($lineMin1) > 0) {
        $check = array_filter([$lineMin1, $line, $lineMin2], 'strlen');

        $numbers = checkLine($check);
        $amount = count($numbers);

        $localSum = array_reduce(
            $numbers,
            function ($a, $i) {
                return $a + $i;
            },
            0
        );

        $sum += $localSum;
    }

    $lineMin2 = $lineMin1;
    $lineMin1 = $line;
}

echo $sum . PHP_EOL;
