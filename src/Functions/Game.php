<?php declare(strict_types=1);

namespace App\Functions;

use App\Models\Mars;
use App\Models\Result;
use App\Models\Rover;
use Widmogrod\Primitive\Listt;
use Widmogrod\Primitive\ListtCons;
use function Widmogrod\Functional\fromIterable;

class Game
{
    public static function initGame(): array
    {
        $cases = [
            [   // Caso 0: Final position (4,2), Direction: N
            'width' => 6,
            'height' => 6,
            'x' => 4,
            'y' => 4,
            'startingDirection' => 'N',
            'obstacles' => [
                ['x' => 4, 'y' => 2],
                ['x' => 5, 'y' => 1],
            ],
            'commands' => [
                'B',
                'B',
                'R',
                'L',
            ]
            ],
            [   // Caso 1: hits obstacle
            'width' => 6,
            'height' => 6,
            'x' => 4,
            'y' => 4,
            'startingDirection' => 'N',
            'obstacles' => [
                ['x' => 4, 'y' => 3],
                ['x' => 5, 'y' => 1],
            ],
            'commands' => [
                'B',
                'B',
            ]
            ],
            [   // Caso 2: Position (1,4) Direction: N
            'width' => 6,
            'height' => 6,
            'x' => 4,
            'y' => 4,
            'startingDirection' => 'N',
            'obstacles' => [
                ['x' => 4, 'y' => 2],
                ['x' => 5, 'y' => 1],
            ],
            'commands' => [
                'R',
                'F',
                'F',
                'L',
            ]
            ],

        ];

        return $cases[0];
    }

    public static function exec(Mars $mars, Rover $rover, array $commands): Result
    {
        return self::doExec(new Result($rover, $mars, false), fromIterable($commands));
    }

    private static function doExec(Result $result, Listt $commands): Result
    {
        if(!$commands instanceof ListtCons || $result->isBlocked()) {
            return $result;
        }
        $result = Command::executeCommand($result->getMars(), $result->getRover(), $commands->head());

        return self::doExec($result, $commands->tail());
    }

    public static function serializeResult(Result $result) : string {
        return sprintf(
            "Rover Status: \n is blocked: %s \n X: %s \n Y: %s \n Direction: %s",
            ($result->isBlocked() ? 'Y' : 'N'),
            $result->getRover()->getPosition()->getX(),
            $result->getRover()->getPosition()->getY(),
            $result->getRover()->getDirection()->getDirectionString()
        );
    }

}
