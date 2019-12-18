<?php


namespace App\Models;


use App\Models\Command\AbstractCommand;

class Game
{
    /** @var Mars $mars */
    private $mars;

    /** @var Rover $rover */
    private $rover;

    /** @var array $commands */
    private $commands;

    public function __construct(Mars $mars, Rover $rover, ?array $command)
    {
        $this->mars = $mars;
        $this-> rover = $rover;
        $this->commands = $command;
    }

    public function getMars(): Mars
    {
        return $this->mars;
    }

    public function getRover(): Rover
    {
        return $this->rover;
    }


    public function getCommands(): ?array
    {
        return $this->commands;
    }
}