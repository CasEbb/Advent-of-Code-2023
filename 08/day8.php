<?php

function parse_map($map)
{
    $directions = [];

    foreach ($map as $instruction) {
        preg_match('/^([A-Z]{3}) = \(([A-Z]{3}), ([A-Z]{3})\)$/', $instruction, $matches);
        $directions[$matches[1]] = [
            "L" => $matches[2],
            "R" => $matches[3],
        ];
    }

    return $directions;
}

$input = file("input", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$instructions = array_slice($input, 0, 1)[0];
$map = array_slice($input, 1);
$map = parse_map($map);

// PART 1
$pos = "AAA";
$step = 0;

// while ($pos != "ZZZ") {
//     $instruction = $instructions[$step % strlen($instructions)];
//     $pos = $map[$pos][$instruction];
//     $step++;
// }

// echo $step . " ";

// PART 2
$positions = array_filter(array_keys($map), fn ($x) => $x[2] === 'A');
$step = 0;

do {
    // Advance positions
    $instruction = $instructions[$step % strlen($instructions)];

    foreach ($positions as $index => $pos) {
        $positions[$index] = $map[$pos][$instruction];
    }

    // Check if end conditions holds
    $step++;
    $allPositionsAtZ = array_reduce($positions, fn ($carry, $item) => $carry && $item[2] === 'Z', true);
    if ($step % 1_000_000 === 0) {
        echo $step . PHP_EOL;
    }
} while (!$allPositionsAtZ && $step < 1_000_000_000);

echo $step . PHP_EOL;
