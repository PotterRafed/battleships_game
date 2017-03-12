<?php

namespace Battleships\Factory;

use Battleships\Core\GameBoard;
use Battleships\Exception\BattleshipsException;

/**
 * Class GameBoardFactory
 * @package AppBundle\Factory
 */
class GameBoardFactory
{
    /**
     * @var array
     */
    private $defaultShipsLengths;

    /**
     * @var GameBoard
     */
    private $gameBoard;

    /**
     * GameBoardFactory constructor.
     * @param GameBoard $gameBoard
     * @param array $defaultShipsLengths
     */
    public function __construct(GameBoard $gameBoard, array $defaultShipsLengths)
    {
        $this->gameBoard = $gameBoard;
        $this->defaultShipsLengths = $defaultShipsLengths;
    }

    /**
     * @return GameBoard
     * @throws BattleshipsException
     */
    public function __invoke() : GameBoard
    {
        foreach ($this->defaultShipsLengths as $shipLength) {

            //Get a random direction for the ship (horizontal or vertical)
            $xDirection = rand(0, 1);
            $yDirection = $xDirection == 1 ? 0 : 1;

            //Try to place a ship with the current orientation
            if (false === $this->attemptShipCreation($xDirection, $yDirection, $shipLength)) {
                //If that was unsuccessful try with reversed orientation
                $xDirection = $xDirection == 0 ? 1 : 0;
                $yDirection = $yDirection  == 0 ? 1 : 0;
                if (false === $this->attemptShipCreation($xDirection, $yDirection, $shipLength)) {
                    //Ship is too large for the board or there is no space left
                    throw new BattleshipsException(sprintf(
                        "Error: Could not place a ship with length %s on the board. Please check the settings for board size and ship lengths.",
                        $shipLength
                    ));
                }
            }
        }
        return $this->gameBoard;
    }

    /**
     * @param $xDir
     * @param $yDir
     * @param $shipLength
     * @return bool
     */
    private function attemptShipCreation($xDir, $yDir, $shipLength)
    {
        //Get a random queue of the available spaces for the width of the board
        $xPositionQueue = $this->getRandomQueueOfNumbers(1, $this->gameBoard->getWidth());
        $shipPlaced = false;

        while (($xPos = array_pop($xPositionQueue)) !== null && $shipPlaced == false) {

            //Get a random queue of the available spaces for the height of the board
            $yPositionQueue = $this->getRandomQueueOfNumbers(1, $this->gameBoard->getHeight());

            while (($yPos = array_pop($yPositionQueue)) !== null && $shipPlaced == false) {

                //Create a ship given a starting location, direction and length
                $ship = ShipFactory::create($xPos, $yPos, $xDir, $yDir, $shipLength);

                //Attempt to place the ship on the board
                $shipPlaced = $this->gameBoard->attemptShipPlacement($ship);
            }
        }
        return $shipPlaced;
    }

    /**
     * @param int $minNumber
     * @param int $maxNumber
     * @return array
     */
    private function getRandomQueueOfNumbers(int $minNumber, int $maxNumber) {
        $numbers = range($minNumber, $maxNumber);
        shuffle($numbers);
        return $numbers;
    }
}