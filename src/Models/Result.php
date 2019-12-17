<?php


namespace App\Models;


use Widmogrod\Monad\Either\Either;

class Result
{
    /** @var Rover $rover */
    private $rover;

    /** @var bool $result */
    private $result;

    public function __construct(Rover $rover, bool $result)
    {
        $this->result = $result;
        $this->rover = $rover;
    }

    public function getRover(): Rover
    {
        return $this->rover;
    }

    public function getResult(): bool
    {
        return $this->result;
    }
}