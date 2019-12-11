<?php declare(strict_types=1);


namespace App\Models;


class CommandL extends AbstractCommand
{
    public function __construct()
    {
        parent::__construct('L');
    }
}