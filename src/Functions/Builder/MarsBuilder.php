<?php declare(strict_types=1);


namespace App\Functions\Builder;


use App\Models\Mars;
use RuntimeException;

class MarsBuilder
{
    public static function build(int $width, int $height, array $obstacles): Mars
    {
        if ($width <= 0 || $height <= 0) {
            throw new RuntimeException("Can't build Mars");
        }

        return new Mars($width, $height, $obstacles);
    }
}