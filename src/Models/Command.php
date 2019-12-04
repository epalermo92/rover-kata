<?php

namespace App\Models;

class Command extends AbstractDirection
{
    public const FORWARD = 'F';

    public const BACKWARD = 'B';

    public const LEFT = 'L';

    public const RIGHT = 'R';

    public $command;

    public function executeCommand(Rover $rover, string $command):Rover
    {
        if ($this->checkCommand($command)) {
            $this->command = $command;
        }
        if (($this->command === self::FORWARD) || ($this->command === self::BACKWARD)) {
            $this->move($rover);
        } elseif (($this->command === self::LEFT) || ($this->command === self::RIGHT)) {
            $this->turn($rover);
        }
        return $rover;
    }

    protected function turn(Rover $rover){
        $directionMapper = [
          AbstractDirection::WEST => AbstractDirection::SOUTH,
          AbstractDirection::SOUTH => AbstractDirection::EAST,
          AbstractDirection::EAST => AbstractDirection::NORTH,
          AbstractDirection::NORTH => AbstractDirection::WEST,
        ];

        if ($this->command === self::LEFT){
            $rover->setDirection($directionMapper[$rover->getDirection()]);
        }
        if ($this->command === self::RIGHT){
            array_flip($directionMapper);
            $rover->setDirection($directionMapper[$rover->getDirection()]);
        }
    }

    protected function move(Rover $rover){
        $movementMapper = array(
            AbstractDirection::NORTH => new Rover($rover->getX(), $rover->getY() +1 , AbstractDirection::NORTH),
            AbstractDirection::SOUTH => new Rover($rover->getX(), $rover->getY() -1 , AbstractDirection::SOUTH),
            AbstractDirection::EAST => new Rover($rover->getX() + 1, $rover->getY(), AbstractDirection::EAST),
            AbstractDirection::WEST => new Rover($rover->getX() -1, $rover->getY(), AbstractDirection::WEST),
            );
        $movementMapper[$rover->getDirection()]();
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