<?php

namespace Battleships\Core;

use Battleships\Exception\InputOutOfBoundariesException;
use Battleships\Objects\PlayBoard;
use Battleships\Objects\Point;
use Battleships\Objects\Ship;
use Battleships\Objects\ShotResult;
use Battleships\Objects\VisiblePoint;

/**
 * Class GameBoard
 * @package AppBundle\Battleships
 */
class GameBoard
{
    /**
     * @var int
     */
    private $displayMode = Game::DISPLAY_MODE_NORMAL;

    /**
     * @var array
     */
    private $ships = [];

    /**
     * @var PlayBoard
     */
    private $playBoard;

    /**
     * @var PlayBoard
     */
    private $cheatBoard;

    /**
     * @var int
     */
    private $noOfAttempts = 0;

    /**
     * @var bool
     */
    private $gameOver = false;

    /**
     * GameBoard constructor.
     * @param PlayBoard $playBoard
     */
    public function __construct(PlayBoard $playBoard)
    {
        $this->playBoard = $playBoard;
        $this->cheatBoard = clone $playBoard;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->playBoard->getWidth();
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->playBoard->getHeight();
    }

    /**
     * @param Point $shootPoint
     * @return ShotResult
     * @throws InputOutOfBoundariesException
     */
    public function shootAt(Point $shootPoint) : ShotResult
    {
        //Check if point is within the boundary of the board
        if (false == $this->playBoard->isPointOnBoard($shootPoint)) {
            throw new InputOutOfBoundariesException();
        }

        $this->noOfAttempts++;

        $result = new ShotResult();

        /** @var Ship $ship */
        foreach ($this->ships as $ship) {

            if (true == $ship->checkAlreadyShot($shootPoint)) {
                return $result;
            }

            if (true == $ship->shoot($shootPoint)) {
                $this->playBoard->addVisiblePoint(new VisiblePoint($shootPoint, VisiblePoint::SHIP_SPACE));

                $message = ShotResult::HIT;

                if (false == $ship->isAlive()) {
                    $message .= ' ' . ShotResult::SHIP_DOWN;
                }

                $result
                    ->setSuccess(true)
                    ->setMessage($message);
                break;
            }
        }

        if (false == $result->isSuccess()) {
            $this->playBoard->addVisiblePoint(new VisiblePoint($shootPoint, VisiblePoint::MISS_SPACE));
        }

        return $result;

    }

    /**
     * @return int
     */
    public function getNumberOfAttempts()
    {
        return $this->noOfAttempts;
    }

    /**
     * @return bool
     */
    public function checkIsGameOver()
    {
        //Check if there is at least one ship still alive
        $allShipsDead = true;
        foreach ($this->ships as $ship) {
            if ($ship->isAlive()) {
                $allShipsDead = false;
                break;
            }
        }
        $this->gameOver = $allShipsDead;
        return $allShipsDead;
    }

    /**
     * @return bool
     */
    public function isGameOver()
    {
        return $this->gameOver;
    }

    /**
     * @param Ship $ship
     */
    public function addNewShip(Ship $ship)
    {
        $this->ships[] = $ship;

        //Add each point of the ship as a visible point in the cheat board
        /** @var Point $point */
        foreach ($ship->getPoints() as $point) {
            $this->cheatBoard->addVisiblePoint(new VisiblePoint($point, VisiblePoint::SHIP_SPACE));
        }
    }

    /**
     * @param Ship $ship
     * @return bool
     */
    public function attemptShipPlacement(Ship $ship)
    {
        //Ships are build from left to right and from top to bottom
        //The first point will always be on the board.
        //Need ot check if the last point of the ship is on the board

        if (false == $this->playBoard->isPointOnBoard($ship->getLastPoint())) {
            return false;
        }

        //Check if the ship is colliding with any other ship already on the board
        if (true == $this->checkShipIsColliding($ship)) {
            return false;
        }

        $this->addNewShip($ship);
        return true;
    }

    /**
     * @param Ship $ship
     * @return bool
     */
    private function checkShipIsColliding(Ship $ship)
    {
        /* @var $existingShip Ship */
        foreach ($this->ships as $existingShip) {
            if (true === $existingShip->isCollidingWithShip($ship)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return array
     */
    public function generateOutputBoard()
    {
        //Return the cheat board if the game is in cheat mode
        if ($this->displayMode == Game::DISPLAY_MODE_CHEAT) {
            return $this->cheatBoard->getDisplayBoardArray();
        }

        return $this->playBoard->getDisplayBoardArray();
    }

    /**
     * @return int
     */
    public function getDisplayMode()
    {
        return $this->displayMode;
    }

    /**
     * @param $displayMode
     */
    public function setDisplayMode(int $displayMode)
    {
        $this->displayMode = $displayMode;
    }
}

