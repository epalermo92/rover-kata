<?php

use src\Entity\Rover;

class Movement extends Rover
{
    function setMovement(string $direction, Rover $position, int $steps)
    {
        switch ($direction) {
            case Rover::NORTH:
                $position->setY($position->getY() + $steps);
                break;
            case Rover::SOUTH:
                $position->setY($position->getY() - $steps);
                break;
            case Rover::EAST:
                $position->setX($position->getX() + $steps);
                break;
            case Rover::WEST:
                $position->setX($position->getX() - $steps);
                break;
            default:
                return $position;
        }
        return $position;
    }

}