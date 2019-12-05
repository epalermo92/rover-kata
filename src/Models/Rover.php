<?php declare(strict_types=1);


namespace App\Models;

class Rover {

    /** @var Position  */
    private  $position;
    /** @var AbstractDirection */
    private $directionFacing;

    public function __construct(int $x, int $y, AbstractDirection $directionFacing)
    {
        $this->position = new Position($x, $y);
        $this->directionFacing = $directionFacing;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function getDirection(): AbstractDirection
    {
        return $this->directionFacing;
    }
}