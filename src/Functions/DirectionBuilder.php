<?php


namespace App\Functions;


use App\Models\AbstractDirection;
use App\Models\DirectionE;
use App\Models\DirectionN;
use App\Models\DirectionS;
use App\Models\DirectionW;

class DirectionBuilder
{
    public static function build(string $direction):AbstractDirection
    {
        $directionMapper = [
            'N' => new DirectionN(),
            'S' => new DirectionS(),
            'E' => new DirectionE(),
            'W' => new DirectionW(),
        ];

        if (in_array($direction,['N', 'S', 'E', 'W']))
        {
            return $directionMapper[$direction];
        }

        throw new \RuntimeException('Invalid direction.');
    }
}