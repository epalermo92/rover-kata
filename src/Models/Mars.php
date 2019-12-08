<?php declare(strict_types=1);

namespace App\Models;


class Mars
{
    /** @var int */
    private $width;
    /** @var int */
    private $height;
    /** @var Position[] */
    private $obstacles;

    public function __construct(int $width, int $height, $obstacles)
    {
        $this->height = $height;
        $this->width = $width;
        $this->obstacles = $obstacles;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getObstacles(): array
    {
        return $this->obstacles;
    }
}