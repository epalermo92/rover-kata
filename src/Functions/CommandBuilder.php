<?php


namespace App\Functions;


use App\Models\AbstractCommand;
use App\Models\CommandB;
use App\Models\CommandF;
use App\Models\CommandL;
use App\Models\CommandR;

class CommandBuilder
{
    public static function build(string $command):AbstractCommand
    {
        $commandMapper = [
            'F' => new CommandF(),
            'B' => new CommandB(),
            'R' => new CommandR(),
            'L' => new CommandL(),
        ];
        if (in_array($command, ['F', 'B', 'R', 'L']))
        {
            return $commandMapper[$command];
        }

        throw new \RuntimeException("Invalid command.\n");
    }
}