<?php


namespace App\Functions;


use App\Models\Position;
use App\Models\Rover;

class Checker
{
    public static function isTheSameRover(Rover $first, Rover $second):bool
    {
        return (
            ($first->getPosition()->getX() === $second->getPosition()->getX()) &&
            ($first->getPosition()->getY() === $second->getPosition()->getY()) &&
            ($first->getDirection()->getDirectionString() === $second->getDirection()->getDirectionString())
        );
    }

    public static function isTheSamePosition(Position $first, Position $second):bool
    {
        return (($first->getX() === $second->getX()) && ($first->getY() === $second->getY()));
    }
}