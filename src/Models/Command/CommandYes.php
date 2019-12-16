<?php


namespace App\Models\Command;


class CommandYes extends AbstractCommand
{
    public function __construct()
    {
        parent::__construct('Y');
    }
}