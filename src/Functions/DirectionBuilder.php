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
            'n' => new DirectionN(),
            'S' => new DirectionS(),
            's' => new DirectionS(),
            'E' => new DirectionE(),
            'e' => new DirectionE(),
            'W' => new DirectionW(),
            'w' => new DirectionW(),
        ];

        if (in_array($direction,['N', 'n', 'S', 's', 'E', 'e', 'W', 'w']))
        {
            return $directionMapper[$direction];
        }

        throw new \RuntimeException('Invalid direction.');
    }
}