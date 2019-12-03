<?php

namespace App\Models;

class Game
{
    private $mars;

    private $rover;

    private $command;

    public function __construct(int $x, int $y, string $startingDirection)
    {
        $this->mars = new Mars(5,5);
        $this->rover = new Rover($x, $y, $startingDirection);
        $this->command = new Command();
    }

    /**
     * @param Mars $mars
     */
    public function setMars(Mars $mars): void
    {
        $this->mars = $mars;
    }

    /**
     * @return Mars
     */
    public function getMars(): Mars
    {
        return $this->mars;
    }

    /**
     * @param Rover $rover
     */
    public function setRover(Rover $rover): void
    {
        $this->rover = $rover;
    }

    /**
     * @return Rover
     */
    public function getRover(): Rover
    {
        return $this->rover;
    }

    public function play(string $command) {
        $this->rover = $this->command->executeCommand($this->rover, $command);
        // TODO Mars va aggiornato!! !?!?
        echo " Actual Rover situation: \n -position" . $this->rover->getX() . $this->rover->getY() .
            "\n -Facing direction: " . $this->rover->getDirection();
    }
}