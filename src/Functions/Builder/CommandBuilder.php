<?php


namespace App\Functions\Builder;


use App\Models\AbstractCommand;
use App\Models\CommandB;
use App\Models\CommandExit;
use App\Models\CommandF;
use App\Models\CommandL;
use App\Models\CommandNo;
use App\Models\CommandR;
use App\Models\CommandYes;

class CommandBuilder
{
    public static function build(string $command): AbstractCommand
    {
        $commandMapper = [
            'F' => (new CommandF()),
            'f' => (new CommandF()),
            'B' => (new CommandB()),
            'b' => (new CommandB()),
            'R' => (new CommandR()),
            'r' => (new CommandR()),
            'L' => (new CommandL()),
            'l' => (new CommandL()),
            'N' => (new CommandNo()),
            'n' => (new CommandNo()),
            'Y' => (new CommandYes()),
            'y' => (new CommandYes()),
            'EXIT' => (new CommandExit()),
            'exit' => (new CommandExit()),
        ];

        if (!in_array($command, ['F', 'f', 'B', 'b', 'R', 'r', 'L', 'l', 'N', 'n', 'Y', 'y', 'EXIT', 'exit'])) {
            throw new \RuntimeException("Can't build the command.\t");
        }

        return $commandMapper[$command];
    }
}