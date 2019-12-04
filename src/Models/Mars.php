<?php declare(strict_types=1);

namespace App\Models;


class Mars
{
    private  $width;

    private  $height;

    public function __construct(int $width, int $height)
    {
        $this->height = $height;
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }
}