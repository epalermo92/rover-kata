<?php

namespace App\Functions;

use App\Models\Mars;
use App\Models\Rover;

class Game
{
    private  $mars;

    private  $rover;

    private  $command;

//    private  $obstacles;

    public function __construct(int $width, int $height, int $x, int $y, string $startingDirection/*, array $obstacles*/)
    {
        $this->mars = new Mars($width,$height);
        $this->rover = new Rover($x, $y, $startingDirection);
        $this->command = new Command();
//        $this->obstacles = $obstacles;
    }

    public function play(string $command) {
        $this->rover = $this->command->executeCommand($this->rover, $command, $this->mars);
        $this->showPosition();
    }

    public function showPosition(){
        echo "\n\t\t\t\tActual Rover position: " .
            "(" .$this->rover->getPosition()->getX() . ", " . $this->rover->getPosition()->getY() . ")" .
            "\n\t\t\t\tFacing direction: \t" . $this->rover->getDirection() . "\n\n";
    }

    /**
     * @return Rover
     */
    public function getRover(): Rover
    {
        return $this->rover;
    }

    /**
     * @return Mars
     */
    public function getMars(): Mars
    {
        return $this->mars;
    }
}