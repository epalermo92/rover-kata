<?php

namespace Models;

class AbstractDirection
{
    public const NORTH = 'N';

    public const SOUTH = 'S';

    public const EAST = 'E';

    public const WEST = 'W';

    protected string $direction;
}