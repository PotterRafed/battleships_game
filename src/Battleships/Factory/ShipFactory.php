<?php

namespace Battleships\Factory;

use Battleships\Objects\Point;
use Battleships\Objects\Ship;

/**
 * Class ShipFactory
 * @package AppBundle\Factory
 */
class ShipFactory
{
    /**
     * @param $startX
     * @param $startY
     * @param $directionX
     * @param $directionY
     * @param $length
     * @return Ship
     */
   public static function create($startX, $startY, $directionX, $directionY, $length) : Ship
   {
       return new Ship(new Point($startX, $startY), new Point($directionX, $directionY), $length);
   }
}