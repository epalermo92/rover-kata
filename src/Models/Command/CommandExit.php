<?php


namespace App\Models;


class CommandExit extends AbstractCommand
{
    public function __construct()
    {
        parent::__construct('EXIT');
    }
}