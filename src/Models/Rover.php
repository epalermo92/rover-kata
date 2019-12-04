<?php


namespace Models;

class Rover extends AbstractDirection {

    private int $x;

    private int $y;

    public function __construct(int $x, int $y, string $directionFacing)
    {
        $this->x = $x;
        $this->y = $y;
        $this->direction = $directionFacing;
    }

    public function getX():int {
        return $this->x;
    }

    public function getY():int
    {
        return $this->y;
    }

    public function getDirection():string {
        return $this->direction;
    }
}