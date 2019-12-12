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
     * @param string[] $commands
     * @return Either<RuntimeException,AbstractCommand>
     */
    public static function build(array $commands): Either
    {
        $commandMap = [
            'F' => (new CommandF()),
            'B' => (new CommandB()),
            'R' => (new CommandR()),
            'L' => (new CommandL()),
        ];
        $arrayCommand = array_map(
            static function ($command) use ($commandMap) {
                if (!array_key_exists(strtoupper($command), $commandMap)) {
                    return left(new \RuntimeException("Can't build the command."));
                }

                return $commandMap[strtoupper($command)];
            },
            $commands
        );

        return right($arrayCommand);
    }
}