<?php


namespace App\Functions;


use App\Models\Rover;

class Checker
{
    public static function areTheSame(Rover $first, Rover $second):bool
    {
        return (
            ($first->getPosition()->getX() === $second->getPosition()->getX()) &&
            ($first->getPosition()->getY() === $second->getPosition()->getY()) &&
            ($first->getDirection()->getDirection() === $second->getDirection()->getDirection())
        );
    }
}