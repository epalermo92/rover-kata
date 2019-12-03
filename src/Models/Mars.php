<?php
declare(strict_types=1);


namespace src\Models;


class Mars
{
    public $width;

    public $height;

    public $mars;

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    protected function create():void {
        $this->mars = [$this->width][$this->height];
    }

    protected function getMars():array {
        return $this->mars;
    }

    protected function updateMars(array $mars):void {
        $this->mars = $mars;
    }
}