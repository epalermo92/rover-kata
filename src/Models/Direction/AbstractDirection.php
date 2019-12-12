<?php declare(strict_types=1);

namespace App\Models\Direction;

abstract class AbstractDirection
{
    /** @var string */
    private $direction;

    public function __construct(string $direction)
    {
        $this->direction = $direction;
    }

    public function getDirectionString(): string
    {
        return $this->direction;
    }
}