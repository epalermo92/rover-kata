<?php

namespace Models;

class Game
{
    private $mars;

    private $rover;

    private $command;

    public function __construct(int $width, int $height, int $x, int $y, string $startingDirection)
    {
        $this->mars = new Mars($width,$height);
        $this->rover = new Rover($x, $y, $startingDirection);
        $this->command = new Command();
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