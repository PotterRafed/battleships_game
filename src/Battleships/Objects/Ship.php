<?php

namespace Battleships\Objects;

/**
 * Class Ship
 * @package AppBundle\Objects
 */
class Ship extends Line
{
    /**
     * @var array
     */
    private $shotPoints = [];

    /**
     * @var array
     */
    private $livePoints;

    /**
     * @var bool
     */
    private $isAlive = true;

    /**
     * Ship constructor.
     * @param Point $start
     * @param Point $direction
     * @param $length
     */
    public function __construct(Point $start, Point $direction, $length)
    {
        parent::__construct($start, $direction, $length);
        $this->livePoints = $this->getPoints();
    }

    /**
     * @param Ship $ship
     * @return bool
     */
    public function isCollidingWithShip(Ship $ship)
    {
        /** @var $myPoint Point */
        foreach ($this->getPoints() as $myPoint) {

            /** @var $otherPoint Point */
            foreach ($ship->getPoints() as $otherPoint) {
                if ($myPoint->isSame($otherPoint)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param Point $point
     * @return bool
     */
    public function shoot(Point $point)
    {
        foreach ($this->livePoints as $key => $myPoint) {
            if ($point->isSame($myPoint)) {
                $this->shotPoints[] = $point;
                unset($this->livePoints[$key]);
                if (empty($this->livePoints)) {
                    $this->isAlive = false;
                }
                return true;
            }
        }
        return false;
    }

    /**
     * @param Point $point
     * @return bool
     */
    public function checkAlreadyShot(Point $point)
    {
        /** @var Point $myPoint */
        foreach ($this->shotPoints as $shotPoint) {
            if ($point->isSame($shotPoint)) {
                return true;
            }
        }
        return false;
    }

    public function getLivePoints()
    {
        return $this->livePoints;
    }

    public function isAlive()
    {
        return $this->isAlive;
    }
}