<?php


namespace App\Functions;


use App\Models\AbstractCommand;
use App\Models\CommandB;
use App\Models\CommandExit;
use App\Models\CommandF;
use App\Models\CommandL;
use App\Models\CommandR;

class CommandBuilder
{
    public static function build(string $command):AbstractCommand
    {
        $commandMapper = [
            'F' => new CommandF(),
            'f' => new CommandF(),
            'B' => new CommandB(),
            'b' => new CommandB(),
            'R' => new CommandR(),
            'r' => new CommandR(),
            'L' => new CommandL(),
            'l' => new CommandL(),
            'EXIT' => new CommandExit(),
            'exit' => new CommandExit(),
        ];

        if (in_array($command, ['F', 'f', 'B', 'b', 'R', 'r', 'L', 'l', 'EXIT', 'exit']))
        {
            return $commandMapper[$command];
        }

        throw new \RuntimeException("Invalid command.\n");
    }
}