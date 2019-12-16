<?php declare(strict_types=1);


namespace App\Models\Command;


class CommandB extends AbstractCommand
{
    public function __construct()
    {
        parent::__construct('B');
    }
}