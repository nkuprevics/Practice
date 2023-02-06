<?php

function generateTestCase(): array
{
    /*
    // Generate an entirely random test case

        $size = rand(1, 10);
        $inputs = [];
        for ($i = 0; $i < $size; $i++) {
            $inputs[] = rand(1, 10);
        }
    */

    // Manual input
    $size = 5;
    $inputs = [1, 3, 1, 5, 2];

    $array = [];
    for ($c = 0; $c < $size; $c++) {
        $array[$c] = $inputs[$c];
    }

    $result = array_fill(0, $size, array_fill(0, $size, -1));

    return [$result, $array, ($size - 1)];
}

function calculateValue($result, $array, $zero, $sizeMinus, $f = 1): int
{
    if ($zero > $sizeMinus) {
        return 0;
    }

    if ($result[$zero][$sizeMinus] != -1) {
        return $result[$zero][$sizeMinus];
    }

    return $result[$zero][$sizeMinus] = max(
        calculateValue($result, $array, $zero + 1, $sizeMinus, $f + 1) + $array[$zero] * $f,
        calculateValue($result, $array, $zero, $sizeMinus - 1, $f + 1) + $array[$sizeMinus] * $f
    );
}

$testCase = generateTestCase();

echo calculateValue(
    $testCase[0],
    $testCase[1],
    0,
    $testCase[2],
);
