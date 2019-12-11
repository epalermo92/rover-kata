<?php declare(strict_types=1);


namespace App\Models;


class AbstractCommand
{
    /** @var string */
    private $command;

    protected function __construct(string $command)
    {
        $this->command = $command;
    }

    public function getCommand(): string
    {
        return $this->command;
    }
}