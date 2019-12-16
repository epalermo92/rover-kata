<?php


namespace App\Functions\Builder;


use App\Models\Direction\AbstractDirection;
use App\Models\Direction\DirectionE;
use App\Models\Direction\DirectionN;
use App\Models\Direction\DirectionS;
use App\Models\Direction\DirectionW;
use Widmogrod\Monad\Either\Either;
use function Widmogrod\Monad\Either\left;
use function Widmogrod\Monad\Either\right;


class DirectionBuilder
{
    /**
     * @param string $direction
     * @return Either<string, AbstractDirection>
     */
    public static function build(string $direction): Either
    {
        $directionMapper = [
            'N' => new DirectionN(),
            'n' => new DirectionN(),
            'S' => new DirectionS(),
            's' => new DirectionS(),
            'E' => new DirectionE(),
            'e' => new DirectionE(),
            'W' => new DirectionW(),
            'w' => new DirectionW(),
        ];

        if (!in_array($direction, ['N', 'n', 'S', 's', 'E', 'e', 'W', 'w'])) {
            return left( new \RuntimeException("Can't build the command."));
        }
        return right($directionMapper[$direction]);

    }
}