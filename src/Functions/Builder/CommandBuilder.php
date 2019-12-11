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
use Widmogrod\Monad\Either\Either;
use function Widmogrod\Monad\Either\left;
use function Widmogrod\Monad\Either\right;

class CommandBuilder
{
    /**
     * @param string $command
     * @return Either<string,AbstractCommand>
     */
    public static function build(string $command): Either
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
            return left("Can't build the command.\t");
        }

        return right($commandMapper[$command]);
    }
}