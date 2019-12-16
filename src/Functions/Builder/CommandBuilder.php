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
    public const COMMAND_MAP = [
        'F' => CommandF::class,
        'B' => CommandB::class,
        'R' => CommandR::class,
        'L' => CommandL::class,
    ];

    /**
     * @param string $command
     * @return Either<RuntimeException,AbstractCommand>
     */
    public static function build(string $command): Either
    {

        if (!array_key_exists(strtoupper($command), self::COMMAND_MAP)) {
            return left(new RuntimeException("Can't build the command."));
        }

        $class = self::COMMAND_MAP[strtoupper($command)];
        return right(new $class);
    }
}