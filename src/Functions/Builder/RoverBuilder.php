<?php declare(strict_types=1);

namespace App\Functions\Builder;

use App\Models\AbstractDirection;
use App\Models\Position;
use App\Models\Rover;
use Widmogrod\Monad\Either\Either;
use function Widmogrod\Functional\liftA2;

class RoverBuilder
{
    public static function build(int $x, int $y, string $direction): Either
    {
        /** @var Either $r */
        $r = liftA2(
            static function (Position $position, AbstractDirection $direction): Rover {
                return new Rover($position, $direction);
            },
            PositionBuilder::build($x, $y),
            DirectionBuilder::build($direction)
        );

        return $r;
    }
}
