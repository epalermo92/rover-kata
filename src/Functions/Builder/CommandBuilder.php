<?php declare(strict_types=1);

namespace App\Functions\Builder;

use App\Models\Command\AbstractCommand;
use App\Models\Command\CommandB;
use App\Models\Command\CommandF;
use App\Models\Command\CommandL;
use App\Models\Command\CommandR;
use RuntimeException;
use Widmogrod\Monad\Either\Either;
use function Widmogrod\Monad\Either\left;
use function Widmogrod\Monad\Either\right;

class CommandBuilder
{
    /**
     * @param string $command
     * @return Either<RuntimeException,AbstractCommand>
     */
    public static function build(string $command): Either
    {
        $commandMap = [
            'F' => (new CommandF()),
            'B' => (new CommandB()),
            'R' => (new CommandR()),
            'L' => (new CommandL()),
        ];
        $cleanCommand = strtoupper($command);

        if (!array_key_exists($cleanCommand, $commandMap)) {
            return left( new \RuntimeException("Can't build the command."));
        }

        return right($commandMap[$cleanCommand]);
    }
}