<?php declare(strict_types=1);

namespace App\Functions;

use App\Models\Command\AbstractCommand;
use App\Models\Mars;
use App\Models\Rover;

class Game
{
    public static function initGame(): array
    {
        $cases = [
            [   // Caso 0: Final position (4,4), Direction: N
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
                'F',
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
                ['x' => 4, 'y' => 2],
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

    public static function play(Mars $mars, Rover $rover, array $commands): Rover
    {
        return Command::executeCommand($mars, $rover, $commands);
    }

    public static function roverStatus(Rover $rover):void {
        echo 'Rover Status:';
        echo "\n x:\t" . $rover->getPosition()->getX();
        echo "\n y:\t" . $rover->getPosition()->getY();
        echo "\n Direction:\t" . $rover->getDirection()->getDirectionString() . "\n";
    }

}
