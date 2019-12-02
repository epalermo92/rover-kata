<?php


namespace swkberlin\Interfaces;


class Position {

    private $x = 0;

    private $y = 0;

    public function setX(int $x):void {
        $this->x = $x;
    }

    public function setY(int $y):void {
        $this->y = $y;
    }

    public function getX():int {
        return $this->x;
    }

    public function getY():int {
        return $this->y;
    }
}