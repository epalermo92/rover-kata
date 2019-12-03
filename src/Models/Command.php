<?php

namespace src\Models;

class Command extends AbstractDirection
{
    public const FORWARD = 'F';

    public const BACKWARD = 'B';

    public const LEFT = 'L';

    public const RIGHT = 'R';

    public $command;

    protected $rover;

    protected function __construct(string $command, Rover $rover )
    {
        if ($this->checkCommand($command)){
            $this->command = $command;
        }

        $this->rover = $rover;
    }

    public function executeCommand():Rover
    {
        if (($this->command === self::FORWARD) || ($this->command === self::BACKWARD)) {
            $this->move();
        } elseif (($this->command === self::LEFT) || ($this->command === self::RIGHT)) {
            $this->turn();
        }
        return $this->rover;
    }

    protected function turn(){
        $roverDirection = $this->rover->getDirection();

        if ($this->command === self::LEFT)
        {
            switch ($roverDirection) {
                case AbstractDirection::WEST:
                    $this->rover->setDirection(AbstractDirection::SOUTH);
                    break;
                case AbstractDirection::SOUTH:
                    $this->rover->setDirection(AbstractDirection::EAST);
                    break;
                case AbstractDirection::EAST:
                    $this->rover->setDirection(AbstractDirection::NORTH);
                    break;
                case AbstractDirection::NORTH:
                    $this->rover->setDirection(AbstractDirection::WEST);
            }
        }

        if ($this->command === self::LEFT)
        {
            switch ($roverDirection) {
                case AbstractDirection::WEST:
                    $this->rover->setDirection(AbstractDirection::NORTH);
                    break;
                case AbstractDirection::NORTH:
                    $this->rover->setDirection(AbstractDirection::EAST);
                    break;
                case AbstractDirection::EAST:
                    $this->rover->setDirection(AbstractDirection::SOUTH);
                    break;
                case AbstractDirection::SOUTH:
                    $this->rover->setDirection(AbstractDirection::WEST);
            }
        }
    }

    protected function move(){

        switch ($this->rover->getDirection()) {
            case AbstractDirection::NORTH:
                $position->setY($position->getY() + 1);
                break;
            case AbstractDirection::SOUTH:
                $position->setY($position->getY() - 1);
                break;
            case AbstractDirection::EAST:
                $position->setX($position->getX() + 1);
                break;
            case AbstractDirection::WEST:
                $position->setX($position->getX() - 1);
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