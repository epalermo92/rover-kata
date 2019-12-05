<?php


namespace App\Models;

class Rover extends AbstractDirection {

    private  $position;

    public function __construct(int $x, int $y, string $directionFacing)
    {
        $this->position = new Position($x, $y);
        $this->direction = $directionFacing;
    }

    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }

    public function getDirection():string {
        return $this->direction;
    }
}