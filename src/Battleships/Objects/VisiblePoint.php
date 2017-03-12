<?php

namespace Battleships\Objects;

/**
 * Class VisiblePoint
 * @package AppBundle\Objects
 */
class VisiblePoint
{
    const EMPTY_SPACE = ".";
    const SHIP_SPACE = "X";
    const MISS_SPACE = "-";

    /**
     * @var Point
     */
    private $point;

    /**
     * @var string
     */
    private $value;

    /**
     * VisiblePoint constructor.
     * @param Point $point
     * @param string $value
     */
    public function __construct(Point $point, string $value = null)
    {
        $this->point = $point;
        $this->value = $value ?? $this::EMPTY_SPACE;
    }

    /**
     * @return Point
     */
    public function getPoint(): Point
    {
        return $this->point;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}