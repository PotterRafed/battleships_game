<?php

namespace Battleships\Exception;

/**
 * Class InputOutOfBoundariesException
 * @package AppBundle\Exception
 */
class InputOutOfBoundariesException extends \Exception
{
    const MESSAGE = "Input is not within the game boundaries";

    /**
     * InputOutOfBoundariesException constructor.
     */
    public function __construct()
    {
        parent::__construct($this::MESSAGE);
    }
}
