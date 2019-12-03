<?php

use src\Models\AbstractDirection;

class Command extends AbstractDirection
{
    public const FORWARD = 'F';

    public const BACKWARD = 'B';

    public const LEFT = 'L';

    public const RIGHT = 'R';

    public $command;

    public $direction;

    protected function __construct(string $command, string $direction)
    {
        if(in_array($command, [self::RIGHT, self::LEFT, self::BACKWARD, self::FORWARD], true)) {
            $this->command = $command;
        }else{
            throw new \InvalidArgumentException('The command' . $command .'is not valid. Available commands: F, B, L, R.' );
        }
        if(in_array($direction, [AbstractDirection::NORTH, AbstractDirection::SOUTH, AbstractDirection::EAST, AbstractDirection::WEST], true)) {
            $this->direction = $direction;
        }else{
            throw new \InvalidArgumentException('The direction' . $direction .'is not valid. Available directions: N, S, E, W. ' );
        }
    }

    public function executeCommand():void
    {
        if (($this->command === self::FORWARD) || ($this->command === self::BACKWARD)) {
            $this->turn();
        } elseif (($this->command === self::LEFT) || ($this->command === self::RIGHT)) {
            $this->move();
        }
    }

    protected function turn(){

    }

    protected function move(){

    }


}