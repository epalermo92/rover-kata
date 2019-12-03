<?php


namespace src\Models;


class AbstractDirection
{
    public const NORTH = 'N';

    public const SOUTH = 'S';

    public const EAST = 'E';

    public const WEST = 'W';

    private $direction;

    public function setDirection(string $direction):void {
        $this->direction = $direction;
    }

    public function getDirection(string $direction):string {
        return $this->direction;
    }
}