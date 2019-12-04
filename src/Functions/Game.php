<?php

namespace App\Functions;

use App\Models\Mars;
use App\Models\Rover;

class Game
{
    private Mars $mars;

    private Rover $rover;

    private string $command;

    private array $obstacles;

    public function __construct(int $width, int $height, int $x, int $y, string $startingDirection, array $obstacles)
    {
        $this->mars = new Mars($width,$height);
        $this->rover = new Rover($x, $y, $startingDirection);
        $this->command = new Command();
        $this->obstacles = $obstacles;
    }

    public function play(string $command) {
        $this->rover = $this->command->executeCommand($this->rover, $command);
        echo " Actual Rover situation: \n -position" . $this->rover->getX() . $this->rover->getY() .
            "\n -Facing direction: " . $this->rover->getDirection();
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