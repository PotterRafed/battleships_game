<?php

namespace Battleships\Objects;

/**
 * Class PlayBoard
 * @package AppBundle\Objects
 */
class PlayBoard
{
    /**
     * @var array
     */
    private $boardArray;

    /**
     * @var Point
     */
    private $dimentions;

    /**
     * PlayBoard constructor.
     * @param Point $dimentions
     */
    public function __construct(Point $dimentions)
    {
        $this->dimentions = $dimentions;
        //Build initial board array
        for ($x = 1; $x <= $dimentions->getX(); $x++) {
            for ($y = 1; $y <= $dimentions->getY(); $y++) {
                $this->addVisiblePoint(new VisiblePoint(new Point($x, $y)));
            }
        }
    }

    /**
     * @param VisiblePoint $point
     */
    public function addVisiblePoint(VisiblePoint $point)
    {
        $this->boardArray[$point->getPoint()->getY()][$point->getPoint()->getX()] = $point->getValue();
    }

    /**
     * @param Point $point
     * @return bool
     */
    public function isPointOnBoard(Point $point)
    {
        return (
            $point->getX() >= 1 &&
            $point->getX() <= $this->getWidth() &&
            $point->getY() >= 1 &&
            $point->getY() <= $this->getHeight()
        );
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->dimentions->getY();
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->dimentions->getX();
    }

    /**
     * Add the letters and numbers to the main board array
     * @return array
     */
    public function getDisplayBoardArray()
    {
        $displayBoardArray = $this->boardArray;

        //Add the numbers on top of the board
        $numbers = array_merge(array(' '), range(1, $this->getWidth()));
        array_unshift($displayBoardArray, $numbers);

        //Add the letters on the left side of the board
        $letter = "A";
        for ($y = 1; $y <= $this->getHeight(); $y++) {
            array_unshift($displayBoardArray[$y], $letter);
            $letter++;
        }
        
        return $displayBoardArray;
    }

}