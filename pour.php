<?php
class Vessel
{
    private $capacity;
    private $fillLevel;

    public function __construct($capacity, $fillLevel)
    {
        $this->capacity = $capacity;
        $this->fillLevel = $fillLevel;
    }

    public function fill($amount = null)
    {
        if ($amount === null) {
            $this->fillLevel = $this->capacity;
        } else {
            $this->fillLevel += $amount;
        }
    }

    public function pourOut($amount = null)
    {
        if ($amount === null) {
            $amount = $this->capacity;
        }
        $this->fillLevel -= $amount;
    }

    public function getFillLevel()
    {
        return $this->fillLevel;
    }

    public function remainingCapacity()
    {
        return $this->capacity - $this->fillLevel;
    }
}

function gcd($a, $b)
{
    if ($b == 0) {
        return $a;
    }
    return gcd($b, $a % $b);
}

function checkIfPossible($testCaseNumbers)
{
    $a = $testCaseNumbers[0];
    $b = $testCaseNumbers[1];
    $c = $testCaseNumbers[2];

    if ($c > $a && $c > $b) {
        return false;
    }
    if ($c % gcd($a, $b) == 0) {
        return true;
    }

    return false;
}

function generateRandomTestCase()
{
    $a = rand(1, 15);
    $b = rand(1, 15);
    $c = rand(1, 15);
    return [$a, $b, $c];
}

function POUR1()
{
    $steps = 0;

    $testCaseNumbers = generateRandomTestCase();

    if (!checkIfPossible($testCaseNumbers)) {
        return -1;
    }

    $a = $testCaseNumbers[0];
    $b = $testCaseNumbers[1];
    $c = $testCaseNumbers[2];

    $vesselA = new Vessel($a, 0);
    $vesselB = new Vessel($b, 0);

    while ($vesselA->getFillLevel() != $c && $vesselB->getFillLevel() != $c) {

        if ($vesselA->getFillLevel() == 0) {
            $vesselA->fill();
            $steps++;
        } else if ($vesselB->getFillLevel() == $b) {
            $vesselB->pourOut();
            $steps++;
        } else {
            $howMuchCanBePouredInB = $vesselB->remainingCapacity();
            $howMuchIsInA = $vesselA->getFillLevel();

            if ($howMuchCanBePouredInB > $howMuchIsInA) {
                $vesselB->fill($howMuchIsInA);
                $vesselA->pourOut($howMuchIsInA);
            } else {
                $vesselB->fill($howMuchCanBePouredInB);
                $vesselA->pourOut($howMuchCanBePouredInB);
            }
            $steps++;
        }
    }
    return $steps;
}

echo POUR1();


