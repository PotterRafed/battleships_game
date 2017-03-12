<?php

namespace Battleships\Input;

use Battleships\Exception\InputOutOfBoundariesException;
use Battleships\Exception\InvalidInputException;
use Battleships\Exception\WrongInputException;
use Battleships\Objects\Point;

/**
 * Class InputHandler
 * @package AppBundle\Input
 */
class InputHandler
{
    const CHEAT_MODE_KEYWORD = 'show';

    /**
     * @var ConvertInputToPoint
     */
    private $convertInputToPoint;

    /**
     * InputHandler constructor.
     * @param ConvertInputToPoint $convertInputToPoint
     */
    public function __construct(ConvertInputToPoint $convertInputToPoint)
    {
        $this->convertInputToPoint = $convertInputToPoint;
    }

    /**
     * @param $input
     * @return bool
     */
    public function isCheatKeyword($input)
    {
        return ($input == $this::CHEAT_MODE_KEYWORD);
    }

    /**
     * @param string $input
     * @return mixed
     */
    public function getShootPoint(string $input)
    {
        return ($this->convertInputToPoint)($input);
    }
}