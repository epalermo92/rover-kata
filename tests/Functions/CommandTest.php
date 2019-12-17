<?php

namespace Unit;

use App\Functions\Command;
use App\Models\Command\CommandF;
use App\Models\Command\CommandR;
use App\Models\Direction\DirectionE;
use App\Models\Direction\DirectionN;
use App\Models\Mars;
use App\Models\Position;
use App\Models\Rover;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{

    public function testExecuteCommandMove(): void
    {
        //TODO
    }

    public function testExecuteCommandTurn(): void
    {
        /** @var Position[] $obstacles */
        $obstacles = [
            new Position(0, 2)
        ];

        $mars = new Mars(4, 4, $obstacles);
        $rover = new Rover(new Position(0, 0), new DirectionN());
        $result = Command::executeCommand($mars, $rover, [
            new CommandR()
        ]);

        $this->assertSame(DirectionE::class, get_class($result->getDirection()));
    }
}
