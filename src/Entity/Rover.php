<?php


namespace src\Entity;

class Rover {

    public const NORTH = 'north';

    public const SOUTH = 'south';

    public const EAST = 'east';

    public const WEST = 'west';

    private $x = 0;

    private $y = 0;

    private $directionFacing;

    public function setX(int $x):void {
        $this->x = $x;
    }

    public function getX():int {
        return $this->x;
    }

    public function setY(int $y):void {
        $this->y = $y;
    }

    public function getY():int
    {
        return $this->y;
    }

    public function setDirection(string $directionFacing):string {
        return $this->directionFacing = $directionFacing;
    }

    public function getDirection():string {
        return $this->directionFacing;
    }
}