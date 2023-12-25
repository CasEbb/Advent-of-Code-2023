<?php

memory_reset_peak_usage();
$start_time = microtime(true);

$_fp = fopen($argv[1] ?? "input", "r");

const TYPE = 0, TO = 1, DATA = 2;

$M = [];
while (!feof($_fp) && $line = trim(fgets($_fp))) {
    [$id, $to] = explode(" -> ", $line);
    $type = $id[0];
    if ($type != "b") $id = substr($id, 1);
    $M[$id] = [$type, explode(", ", $to), ($type == "&" ? [] : 0)];
}
fclose($_fp);

foreach ($M as $id => [, $to,]) foreach ($to as $d) {
    if (!isset($M[$d])) $M[$d] = [$d, [], []];
    if ($M[$d][TYPE] == "&" || $M[$d][TYPE] == $d) $M[$d][DATA][$id] = 0;
}

$part1 = $part2 = 0;
$count = [0, 0];
$CYCLES = $M[array_key_first($M["rx"][DATA])][DATA];
$FOUND = [];

for ($i = 0;; $i++) {
    if ($i == 1000) $part1 = $count[0] * $count[1];

    $Q = [["broadcaster", "button", 0]];
    while (count($Q)) {
        [$id, $from, $pulse] = array_shift($Q);
        //        echo "{$from} -".["low","high"][$pulse]."-> {$id}\n";

        $count[$pulse]++;

        if (!$pulse && isset($CYCLES[$id])) {
            if ($CYCLES[$id] > 0 && !isset($FOUND[$id])) {
                $FOUND[$id] = $i - $CYCLES[$id];
                //                echo "{$id} CYCLE FOUND at {$i} length {$FOUND[$id]}\n";
                if (count($FOUND) == count($CYCLES)) {
                    $part2 = array_shift($FOUND);
                    foreach ($FOUND as $n) $part2 = gmp_lcm($part2, $n);
                    break 2;
                }
            } else $CYCLES[$id] = $i;
        }

        if ($M[$id][TYPE] == "%") {
            if ($pulse) continue;
            $pulse = $M[$id][DATA] = (int)!$M[$id][DATA];
        } elseif ($M[$id][TYPE] == "&") {
            $M[$id][DATA][$from] = $pulse;
            $pulse = (int)!(array_sum($M[$id][DATA]) == count($M[$id][DATA]));
        }

        foreach ($M[$id][TO] as $to) $Q[] = [$to, $id, $pulse];
    }
}

echo "part 1: {$part1}\n";
echo "part 2: {$part2}\n";

echo "Execution time: " . round(microtime(true) - $start_time, 4) . " seconds\n";
echo "   Peak memory: " . round(memory_get_peak_usage() / pow(2, 20), 4), " MiB\n\n";
