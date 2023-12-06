<?php

$input = [
    42 => 284,
    68 => 1005,
    69 => 1122,
    85 => 1341,
];

$possibilities = [];

foreach ($input as $time => $recordDistance) {
    $numPossibilities = 0;
    for ($chargingTime = 1; $chargingTime < $time; $chargingTime++) {
        $speed = $chargingTime;
        $travelTime = $time - $chargingTime;
        $distanceTraveled = $travelTime * $speed;

        if ($distanceTraveled > $recordDistance) {
            $numPossibilities++;
        }
    }
    $possibilities[] = $numPossibilities;
}

echo array_reduce($possibilities, fn ($carry, $item) => $carry * $item, 1);
echo " ";

// PART 2
$time = 42686985;
$distanceToBeat = 284100511221341;
$possibilities = 0;

for ($chargingTime = 1; $chargingTime < $time; $chargingTime++) {
    $speed = $chargingTime;
    $travelTime = $time - $chargingTime;
    $distanceTraveled = $travelTime * $speed;

    if ($distanceTraveled > $distanceToBeat) {
        $possibilities++;
    }
}

echo $possibilities;
echo PHP_EOL;
