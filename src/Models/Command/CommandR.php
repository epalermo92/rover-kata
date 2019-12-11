<?php declare(strict_types=1);


namespace App\Models;


class CommandR extends AbstractCommand
{
    public function __construct()
    {
        parent::__construct('R');
    }
}