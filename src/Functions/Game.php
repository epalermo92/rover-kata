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
        echo "\nActual Rover position:" . "\n\t\t\t\t\t\t- x: " . $this->rover->getX() . "\n\t\t\t\t\t\t- y: " . $this->rover->getY() .
            "\n\t\t\t\t - Facing direction: " . $this->rover->getDirection() . "\n\n";
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