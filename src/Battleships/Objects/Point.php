<?php

namespace Battleships\Objects;

/**
 * Class Point
 * @package AppBundle\Objects
 */
class Point
{
    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * Point constructor.
     * @param int $x
     * @param int $y
     */
    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

//    /**
//     * @return Point
//     */
//    public function changeDirection()
//    {
//        return new Point($this->getY(), $this->getX());
//    }

    /**
     * @param Point $point
     * @return Point
     */
    public function movePoint(Point $point)
    {
        return new Point($this->getX() + $point->getX(), $this->getY() + $point->getY());
    }

    /**
     * @param Point $point
     * @return bool
     */
    public function isSame(Point $point)
    {
        return $this->getX() == $point->getX() && $this->getY() == $point->getY();
    }

}