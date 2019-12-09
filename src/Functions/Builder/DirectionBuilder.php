<?php


namespace App\Functions\Builder;


use App\Models\AbstractDirection;
use App\Models\DirectionE;
use App\Models\DirectionN;
use App\Models\DirectionS;
use App\Models\DirectionW;


class DirectionBuilder
{
    public static function build(string $direction): AbstractDirection
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

        if (in_array($direction, ['N', 'n', 'S', 's', 'E', 'e', 'W', 'w'])) {
            throw new \RuntimeException("Can't build the command.\t");
        }
        return $directionMapper[$direction];

    }
}