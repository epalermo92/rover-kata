<?php

namespace tests\Functions;

use App\Functions\Command;
use App\Models\Command\CommandB;
use App\Models\Command\CommandF;
use App\Models\Command\CommandL;
use App\Models\Command\CommandR;
use App\Models\Direction\DirectionE;
use App\Models\Direction\DirectionN;
use App\Models\Direction\DirectionW;
use App\Models\Mars;
use App\Models\Position;
use App\Models\Rover;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{

    /**
     * @dataProvider CommandProvider
     */
    public function testExecuteCommandMove($command, $x, $y, $direction)
    {
        $mars = new Mars(
            8,
            8,
            [new Position(1, 3), new Position(2, 5)]
        );
        $rover = new Rover(new Position(2, 2), new DirectionN());
        $command = [new $command];

        $result = Command::executeCommand($mars, $rover, $command);

        $this->assertSame($x, $result->getPosition()->getX());
        $this->assertSame($y, $result->getPosition()->getY());
        $this->assertSame($direction, get_class($result->getDirection()));
    }

    public function CommandProvider(): array
    {
        return [
            [
                CommandF::class,
                2,
                3,
                DirectionN::class
            ],
            [
                CommandB::class,
                2,
                1,
                DirectionN::class
            ],
        ];
    }

    /**
     * @dataProvider turnProvider
     */
    public function testExecuteCommandTurn($command, $initialDirection, $finalDirection): void
    {
        /** @var Position[] $obstacles */
        $obstacles = [
            new Position(0, 2)
        ];

        $mars = new Mars(4, 4, $obstacles);
        $rover = new Rover(new Position(0, 0), $initialDirection);
        $result = Command::executeCommand($mars, $rover, [
            $command
        ]);

        $this->assertSame($finalDirection, get_class($result->getDirection()));
    }

    public function turnProvider(): array
    {
        return [
            [new CommandR(), new DirectionN(), DirectionE::class],
            [new CommandL(), new DirectionN(), DirectionW::class],
        ];
    }
}
