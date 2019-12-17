<?php declare(strict_types=1);

namespace App\Models;

use Widmogrod\Monad\Either\Either;

class Result
{
    /** @var Rover $rover */
    private $rover;

    /** @var Mars */
    private $mars;

    /** @var bool $blocked */
    private $blocked;

    public function __construct(Rover $rover, Mars $mars, bool $blocked)
    {
        $this->blocked = $blocked;
        $this->rover = $rover;
        $this->mars = $mars;
    }

    public function getRover(): Rover
    {
        return $this->rover;
    }

    public function isBlocked(): bool
    {
        return $this->blocked;
    }

    public function getMars(): Mars
    {
        return $this->mars;
    }
}