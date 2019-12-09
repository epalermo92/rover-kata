<?php


namespace App\Models;


class DirectionWrong extends AbstractDirection
{
    public function __construct()
    {
        parent::__construct('ERR');
    }
}