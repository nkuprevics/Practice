<?php
class Vessel
{
    private int $capacity;
    private int $fillLevel;

    public function __construct(int $capacity, int $fillLevel)
    {
        $this->capacity = $capacity;
        $this->fillLevel = $fillLevel;
    }

    public function fill($amount = null):void
    {
        if ($amount === null) {
            $this->fillLevel = $this->capacity;
        } else {
            $this->fillLevel += $amount;
        }
    }

    public function pourOut($amount = null):void
    {
        if ($amount === null) {
            $amount = $this->capacity;
        }
        $this->fillLevel -= $amount;
    }

    public function getFillLevel():int
    {
        return $this->fillLevel;
    }

    public function remainingCapacity():int
    {
        return $this->capacity - $this->fillLevel;
    }
}

function generateRandomTestCase():array
{
    $a = rand(1, 10);
    $b = rand(1, 10);
    $c = rand(1, 10);
    return [$a, $b, $c];
}

function checkIfTestCaseIsValid(array $testCaseNumbers):bool
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

function gcd($a, $b)
{
    if ($b == 0) {
        return $a;
    }
    return gcd($b, $a % $b);
}

function POUR1()
{
    $steps = 0;

    $testCaseNumbers = generateRandomTestCase();
    //$testCaseNumbers = [2, 5, 3];

    if (!checkIfTestCaseIsValid($testCaseNumbers)) {
        return -1;
    }

    $a = $testCaseNumbers[0];
    $b = $testCaseNumbers[1];
    $c = $testCaseNumbers[2];

    if ($a>$b) {
        $vesselA = new Vessel($a, 0);
        $vesselB = new Vessel($b, 0);
    } else {
        $vesselA = new Vessel($b, 0);
        $vesselB = new Vessel($a, 0);
    }

    while ($vesselA->getFillLevel() != $c && $vesselB->getFillLevel() != $c) {

        if ($vesselA->getFillLevel() == 0) {
            $vesselA->fill();
            $steps++;

        }
        else if ($vesselB->getFillLevel() == $b) {
            $vesselB->pourOut();
            $steps++;

        } else {
            $howMuchCanBePouredInB = $vesselB->remainingCapacity();
            $howMuchIsInA = $vesselA->getFillLevel();

            if ($howMuchCanBePouredInB >= $howMuchIsInA) {
                $vesselB->fill($howMuchIsInA);
                $vesselA->pourOut($howMuchIsInA);
            } elseif ($vesselB->remainingCapacity() == 0) {
                $vesselB->pourOut();
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

