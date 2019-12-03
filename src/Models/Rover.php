<?php


namespace src\Models;

class Rover {

    private $x = 0;

    private $y = 0;

    private $directionFacing;

    protected function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

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