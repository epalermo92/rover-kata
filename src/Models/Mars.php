<?php


namespace Models;


class Mars
{
    private int $width;

    private int $height;

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