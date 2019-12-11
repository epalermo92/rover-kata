<?php


namespace App\Functions\Checker;


use App\Functions\Command;
use App\Models\Mars;
use App\Models\Position;
use App\Models\Rover;

class Checker
{
    public static function isTheSameRover(Rover $first, Rover $second): bool
    {
        return (
            ($first->getPosition()->getX() === $second->getPosition()->getX()) &&
            ($first->getPosition()->getY() === $second->getPosition()->getY()) &&
            ($first->getDirection()->getDirectionString() === $second->getDirection()->getDirectionString())
        );
    }

    public static function isTheSamePosition(Position $first, Position $second): bool
    {
        return (($first->getX() === $second->getX()) && ($first->getY() === $second->getY()));
    }

    public static function checkRoverLimits(Rover $rover, Mars $mars): Rover
    {
        if ($rover->getPosition()->getX() < 1) {
            return new Rover(Command::buildPosition($mars->getWidth(), $rover->getPosition()->getY()), $rover->getDirection());
        }
        if ($rover->getPosition()->getX() > $mars->getWidth()) {
            return new Rover(Command::buildPosition(1, $rover->getPosition()->getY()), $rover->getDirection());
        }
        if ($rover->getPosition()->getY() < 1) {
            return new Rover(Command::buildPosition($rover->getPosition()->getX(), $mars->getHeight()), $rover->getDirection());
        }
        if ($rover->getPosition()->getY() > $mars->getHeight()) {
            return new Rover(Command::buildPosition($rover->getPosition()->getX(), 1), $rover->getDirection());
        }

        return $rover;
    }
}