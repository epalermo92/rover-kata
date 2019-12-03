<?php

namespace src\Models;

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
        $roverDirection = $rover->getDirection();

        if ($this->command === self::LEFT)
        {
            switch ($roverDirection) {
                case AbstractDirection::WEST:
                    $rover->setDirection(AbstractDirection::SOUTH);
                    break;
                case AbstractDirection::SOUTH:
                    $rover->setDirection(AbstractDirection::EAST);
                    break;
                case AbstractDirection::EAST:
                    $rover->setDirection(AbstractDirection::NORTH);
                    break;
                case AbstractDirection::NORTH:
                    $rover->setDirection(AbstractDirection::WEST);
            }
        }

        if ($this->command === self::LEFT)
        {
            switch ($roverDirection) {
                case AbstractDirection::WEST:
                    $rover->setDirection(AbstractDirection::NORTH);
                    break;
                case AbstractDirection::NORTH:
                    $rover->setDirection(AbstractDirection::EAST);
                    break;
                case AbstractDirection::EAST:
                    $rover->setDirection(AbstractDirection::SOUTH);
                    break;
                case AbstractDirection::SOUTH:
                    $rover->setDirection(AbstractDirection::WEST);
            }
        }
    }

    protected function move(Rover $rover){

        switch ($rover->getDirection()) {
            case AbstractDirection::NORTH:
                $rover->setY($position->getY() + 1);
                break;
            case AbstractDirection::SOUTH:
                $rover->setY($position->getY() - 1);
                break;
            case AbstractDirection::EAST:
                $rover->setX($position->getX() + 1);
                break;
            case AbstractDirection::WEST:
                $rover->setX($position->getX() - 1);
                break;
        }
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