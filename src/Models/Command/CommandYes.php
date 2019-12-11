<?php


namespace App\Models;


class CommandYes extends AbstractCommand
{
    public function __construct()
    {
        parent::__construct('Y');
    }
}