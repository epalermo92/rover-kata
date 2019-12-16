<?php


namespace App\Models\Command;


class CommandExit extends AbstractCommand
{
    public function __construct()
    {
        parent::__construct('EXIT');
    }
}