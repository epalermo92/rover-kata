<?php


namespace App\Functions\Builder;


use App\Models\AbstractDirection;
use App\Models\DirectionE;
use App\Models\DirectionN;
use App\Models\DirectionS;
use App\Models\DirectionW;
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
            return left("Can't build the command.\t");
        }
        return right($directionMapper[$direction]);

    }
}