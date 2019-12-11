<?php declare(strict_types=1);


namespace App\Functions\Builder;


use App\Models\Mars;
use RuntimeException;
use Widmogrod\Monad\Either\Either;
use function Widmogrod\Monad\Either\left;
use function Widmogrod\Monad\Either\right;

class MarsBuilder
{
    /**
     * @param int $width
     * @param int $height
     * @param array $obstacles
     * @return Either<string, Mars>
     */
    public static function build(int $width, int $height, array $obstacles): Either
    {
        if ($width <= 0 || $height <= 0) {
            return left( new \RuntimeException("Can't build Mars, Width and Height must be positive."));
        }

        return right(new Mars($width, $height, $obstacles));
    }
}