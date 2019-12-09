<?php


namespace App\Models;


class CommandWrong extends AbstractCommand
{
    public function __construct()
    {
        parent::__construct('ERR');
    }
}