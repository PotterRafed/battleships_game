<?php

namespace Battleships\Objects;

/**
 * Class ShotResult
 * @package AppBundle\Objects
 */
class ShotResult
{
    const MISS = 'Miss!';
    const HIT = 'Hit!';
    const SHIP_DOWN = 'Ship Down!';

    /**
     * @var bool
     */
    private $success;

    /**
     * @var string
     */
    private $message;

    /**
     * ShotResult constructor.
     * @param bool $success
     * @param string $message
     */
    public function __construct($success = false, $message = null)
    {
        $this->success = $success;
        $this->message = $message ?? $this::MISS;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return ShotResult
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @param boolean $success
     * @return ShotResult
     */
    public function setSuccess(bool $success)
    {
        $this->success = $success;
        return $this;
    }

}