<?php

$input = file("input", FILE_IGNORE_NEW_LINES);
$scores = [];
$cardCounts = [];

foreach ($input as $idx => $line) {
    if (!isset($cardCounts[$idx])) {
        $cardCounts[$idx] = 1;
    }
    $parts = explode('|', $line);
    $winningNumbersPart = trim(substr($parts[0], strpos($parts[0], ':') + 1));
    $yourNumbersPart = trim($parts[1]);
    $winningNumbers = preg_split('/\s+/', $winningNumbersPart);
    $myNumbers = preg_split('/\s+/', $yourNumbersPart);
    $numWins = count(array_intersect($winningNumbers, $myNumbers));
    $points = $numWins > 0 ? pow(2, $numWins - 1) : 0;

    for ($j = 1; $j <= $numWins; $j++) {
        $next_key = $idx + $j;
        if ($next_key >= count($input)) {
            break;
        }
        if (!isset($cardCounts[$next_key])) {
            $cardCounts[$next_key] = 1 + $cardCounts[$idx];
        } else {
            $cardCounts[$next_key] += $cardCounts[$idx];
        }
    }

    $scores[] = $points;
}

echo array_sum($scores);
echo " ";
echo array_sum($cardCounts);
echo PHP_EOL;
