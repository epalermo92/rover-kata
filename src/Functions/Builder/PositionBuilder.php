<?php declare(strict_types=1);


namespace App\Functions\Builder;


use App\Models\Position;
use Widmogrod\Monad\Either\Either;
use function Widmogrod\Monad\Either\left;
use function Widmogrod\Monad\Either\right;

class PositionBuilder
{
    /**
     * @param int $x
     * @param int $y
     * @return Either<string, Position>
     */
    public static function build(int $x, int $y): Either
    {
        if ($x < 0 || $y < 0) {
            return left("Coordinates must be positive numbers.");
        }

        return right(new Position($x, $y));
    }
}