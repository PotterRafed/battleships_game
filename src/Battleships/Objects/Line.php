<?php

namespace Battleships\Objects;

/**
 * Class Line
 * @package AppBundle\Objects
 */
class Line
{
    /**
     * @var array
     */
    private $points;

    /**
     * @var
     */
    private $length;

    public function __construct(Point $start, Point $direction, $length)
    {
        $this->length = $length;
        $this->points[] = $start;

        for ($i = 1; $i < $length; $i++) {

            //Move the last point in the line and save that in the array
            $this->points[] = end($this->points)->movePoint($direction);
            reset($this->points);


//            $start = $start->movePoint($direction);
//            $this->points[] = $start;
        }
    }

    /**
     * @return mixed
     */
    public function getLastPoint()
    {
        return end($this->points);
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return array
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param Point $point
     */
    private function addLinePoint(Point $point)
    {
        $this->points[] = $point;
    }
}