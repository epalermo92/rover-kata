<?php

namespace App\Functions;

use App\Models\AbstractDirection;
use App\Models\Mars;
use App\Models\Rover;

class Command extends AbstractDirection
{
    public const FORWARD = 'F';

    public const BACKWARD = 'B';

    public const LEFT = 'L';

    public const RIGHT = 'R';

    public  $command;

    public function executeCommand(Rover $rover, string $command, Mars $mars):Rover
    {
        if ($this->checkCommand($command)) {
            $this->command = $command;
        }
        if (($this->command === self::FORWARD) || ($this->command === self::BACKWARD)) {
            $rover = $this->move($rover,$command);
        } elseif (($this->command === self::LEFT) || ($this->command === self::RIGHT)) {
            $rover = $this->turn($rover);
        }
        return $this->checkRoverLimits($rover, $mars);
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
            $newRover = new Rover($rover->getPosition()->getX(), $rover->getPosition()->getY(), $directionMapper[$rover->getDirection()]);
        }
        if ($this->command === self::RIGHT){
            $flippedDirectionMapper = array_flip($directionMapper);
            $newRover = new Rover($rover->getPosition()->getX(), $rover->getPosition()->getY(), $flippedDirectionMapper[$rover->getDirection()]);
        }
        return $newRover;
    }

    protected function move(Rover $rover,$command):Rover{
        $x = $rover->getPosition()->getX();
        $y = $rover->getPosition()->getY();
        if ($command === Command::FORWARD) {
            $movementMapper = array(
                AbstractDirection::NORTH => new Rover($x, $y + 1, AbstractDirection::NORTH),
                AbstractDirection::SOUTH => new Rover($x, $y - 1, AbstractDirection::SOUTH),
                AbstractDirection::EAST => new Rover($x + 1, $y, AbstractDirection::EAST),
                AbstractDirection::WEST => new Rover($x - 1, $y, AbstractDirection::WEST),
            );
        }
        if ($command === Command::BACKWARD) {
            $movementMapper = array(
                AbstractDirection::NORTH => new Rover($x, $y - 1, AbstractDirection::NORTH),
                AbstractDirection::SOUTH => new Rover($x, $y + 1, AbstractDirection::SOUTH),
                AbstractDirection::EAST => new Rover($x - 1, $y, AbstractDirection::EAST),
                AbstractDirection::WEST => new Rover($x + 1, $y, AbstractDirection::WEST),
            );
        }
        return $movementMapper[$rover->getDirection()];
    }

    public function checkRoverLimits(Rover $rover, Mars $mars):Rover{
        $x = $rover->getPosition()->getX();
        $y = $rover->getPosition()->getY();
        if($x < 1){
            return new Rover($mars->getWidth(), $y, $rover->getDirection());
        }elseif($x > $mars->getWidth()){
            return new Rover(1, $y, $rover->getDirection());
        }elseif($y < 1){
            return new Rover($x, $mars->getHeight(), $rover->getDirection());
        }elseif($y > $mars->getHeight()){
            return new Rover($x, 1, $rover->getDirection());
        }
        return $rover;
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