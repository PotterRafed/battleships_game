<?php

namespace Battleships\Input;

use Battleships\Exception\InputOutOfBoundariesException;
use Battleships\Exception\InvalidInputException;
use Battleships\Exception\WrongInputException;
use Battleships\Objects\Point;

class ConvertInputToPoint
{
    /**
     * @var Point
     */
    private $boardDimentions;

    /**
     * InputConverter constructor.
     * @param Point $boardDimentions
     */
    public function __construct(Point $boardDimentions)
    {
        $this->boardDimentions = $boardDimentions;
    }

    /**
     * @param string $input
     * @return Point
     * @throws InvalidInputException
     */
    public function __invoke(string $input) : Point
    {
        $input = strtoupper($input);
        if (0 === preg_match("/^[A-Z]+[0-9]+$/", $input)) {
            throw new InvalidInputException("Invalid input");
        }

        //Get the number part
        preg_match("/[0-9]+$/", $input, $number);
        $x = $number[0];

        //Get the letter part
        preg_match("/^[A-Z]+/", $input, $letter);
        $y = $this->letterToNumber($letter[0]);

        return new Point($x, $y);
    }

    /**
     * @param string $letter
     * @return int
     * @throws InputOutOfBoundariesException
     */
    private function letterToNumber(string $letter)
    {
        $number = 1;
        $letterIterator = "A";
        $maxNumbers = $this->boardDimentions->getY();

        while ($letterIterator != $letter) {
            $number++;
            $letterIterator++;
            if ($number > $maxNumbers) {
                throw new InputOutOfBoundariesException();
            }
        }
        
        return $number;
    }
}