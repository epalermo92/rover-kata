<?php declare(strict_types=1);


namespace App\Models;

class Rover
{

    /** @var Position */
    private $position;
    /** @var AbstractDirection */
    private $directionFacing;

    public function __construct(Position $position, AbstractDirection $directionFacing)
    {
        $this->position = $position;
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