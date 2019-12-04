<?php


namespace Models;

class Rover extends AbstractDirection {

    private Position $position;

    public function __construct(int $x, int $y, string $directionFacing)
    {
        $this->position = new Position($x, $y);
        $this->direction = $directionFacing;
    }

    public function getX():int {
        return $this->position->getX();
    }

    public function getY():int
    {
        return $this->position->getY();
    }

    public function getDirection():string {
        return $this->direction;
    }
}