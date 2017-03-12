<?php

namespace Battleships\Exception;

/**
 * Class InvalidInputException
 * @package AppBundle\Exception
 */
class InvalidInputException extends \Exception
{
    const MESSAGE = "Invalid input. Please write a letter followed by a number (e.g. 'A5')";

    /**
     * InputOutOfBoundariesException constructor.
     */
    public function __construct()
    {
        parent::__construct($this::MESSAGE);
    }
}
