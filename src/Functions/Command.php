<?php

namespace App\Functions;

use App\Models\AbstractDirection;
use App\Models\Rover;

class Command extends AbstractDirection
{
    public const FORWARD = 'F';

    public const BACKWARD = 'B';

    public const LEFT = 'L';

    public const RIGHT = 'R';

    public  $command;

    public function executeCommand(Rover $rover, string $command):Rover
    {
        if ($this->checkCommand($command)) {
            $this->command = $command;
        }
        if (($this->command === self::FORWARD) || ($this->command === self::BACKWARD)) {
            $rover = $this->move($rover,$command);
        } elseif (($this->command === self::LEFT) || ($this->command === self::RIGHT)) {
            $rover = $this->turn($rover);
        }
        return $rover;
    }

    protected function turn(Rover $rover):Rover {
        $directionMapper = [
            Rover::WEST => Rover::SOUTH,
            Rover::SOUTH => Rover::EAST,
            Rover::EAST => Rover::NORTH,
            Rover::NORTH => Rover::WEST,
        ];
        $newRover = new Rover(0,0,Rover::NORTH);
        if ($this->command === self::LEFT){
            $newRover = new Rover($rover->getX(), $rover->getY(), $directionMapper[$rover->getDirection()]);
        }
        if ($this->command === self::RIGHT){
            array_flip($directionMapper);
            $newRover = new Rover($rover->getX(), $rover->getY(), $directionMapper[$rover->getDirection()]);
        }
        return $newRover;
    }

    protected function move(Rover $rover,$command):Rover{
        if ($command === Command::FORWARD) {
            $movementMapper = array(
                AbstractDirection::NORTH => new Rover($rover->getX(), $rover->getY() + 1, AbstractDirection::NORTH),
                AbstractDirection::SOUTH => new Rover($rover->getX(), $rover->getY() - 1, AbstractDirection::SOUTH),
                AbstractDirection::EAST => new Rover($rover->getX() + 1, $rover->getY(), AbstractDirection::EAST),
                AbstractDirection::WEST => new Rover($rover->getX() - 1, $rover->getY(), AbstractDirection::WEST),
            );
        }
        if ($command === Command::BACKWARD) {
            $movementMapper = array(
                AbstractDirection::NORTH => new Rover($rover->getX(), $rover->getY() - 1, AbstractDirection::NORTH),
                AbstractDirection::SOUTH => new Rover($rover->getX(), $rover->getY() + 1, AbstractDirection::SOUTH),
                AbstractDirection::EAST => new Rover($rover->getX() - 1, $rover->getY(), AbstractDirection::EAST),
                AbstractDirection::WEST => new Rover($rover->getX() + 1, $rover->getY(), AbstractDirection::WEST),
            );
        }

         return $movementMapper[$rover->getDirection()];
    }

    /**
     * @param string $command
     * @return bool
     */
    protected function checkCommand(string $command): bool
    {
        if (in_array($command, [self::RIGHT, self::LEFT, self::BACKWARD, self::FORWARD], true)) {
            return true;
        }

        throw new \InvalidArgumentException('The command' . $command . 'is not valid. Available commands: F, B, L, R.');
    }
}