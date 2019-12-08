<?php declare(strict_types=1);


namespace App\Functions;


use App\Models\Position;
use RuntimeException;

class PositionBuilder
{
    public static function build(int $x, int $y): Position
    {
        if ($x < 0 || $y < 0) {
            throw new RuntimeException("Can't build Position");
        }

        return new Position($x, $y);
    }
}