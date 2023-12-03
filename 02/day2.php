<?php

$f = fopen("input", "r");

$possibleGames = [];

$limits = [
    "red" => 12,
    "green" => 13,
    "blue" => 14,
];
$powers = [];

while($line = fgets($f)) {
    preg_match("/^Game (\d+): (.*)$/", $line, $matches);

    $gameId = intval($matches[1]);
    $gamePossible = true;
    $minimums = [
        "red" => 0,
        "green" => 0,
        "blue" => 0,
    ];

    foreach(explode("; ", $matches[2]) as $grab) {
        $sets = explode(", ", $grab);
        $sets = array_map(fn ($x) => explode(" ", $x), $sets);
        foreach ($sets as $set) {
            $quantity = intval($set[0]);
            $color = $set[1];
            $minimums[$color] = max($minimums[$color], $quantity);
            if ($quantity > $limits[$color]) {
                $gamePossible = false;
            }
        }
    }

    $powers[] = array_reduce($minimums, fn ($carry, $item) => $item * $carry, 1);

    if ($gamePossible) {
        $possibleGames[] = $gameId;
    }
}

echo array_sum($possibleGames);
echo " ";
echo array_sum($powers);
echo PHP_EOL;
