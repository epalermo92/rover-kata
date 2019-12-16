<?php declare(strict_types=1);

namespace App\Functions;

use App\Models\Command\AbstractCommand;
use App\Models\Mars;
use App\Models\Rover;
use Widmogrod\Monad\Either\Either;
use function Widmogrod\Monad\Either\right;

class Game
{
    public static function initGame(): array
    {
        return [
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
        ];
    }

    /**
     * @param Mars $mars
     * @param Rover $rover
     * @param AbstractCommand[] $commands
     *
     * @return Either
     */
    public static function play(Mars $mars, Rover $rover, array $commands): Either
    {
        return right('ok');
    }
}
//        self::showPosition($rover, $mars);
//
//        do {
//
//            echo "Insert the command you want to execute:\n\n F: Step Forward\n B: Step Backward\n R: Turn Right\n L: Turn Left\n\n";
//            $command = CommandBuilder::build(InputChecker::inputCommandFromTerminal())
//            ->either(
//                static function ($string) {
//                    throw new \RuntimeException($string);
//                },
//                static function ($command) {
//                    return $command;
//                }
//            );
//            $rover = self::newRound($command, $mars, $rover);
//        } while ($command !== 'exit');
//
//        return true;
//    public static function showPosition(Rover $rover, Mars $mars)
//    {
//        $marsField = [$mars->getHeight()][$mars->getWidth()];
//
//        for ($c = 1; $c <= $mars->getWidth(); $c++)
//        {
//            for ($i = 1; $i <= $mars->getHeight(); $i++)
//            {
//                $marsField[$i][$c] = 'O';
//            }
//        }
//
//        $marsField[($rover->getPosition()->getY())][$rover->getPosition()->getX()] = 'X';
//
//        echo "\n\t\t\t\tActual Rover position: " .
//            '(' . $rover->getPosition()->getX() . ', ' . $rover->getPosition()->getY() . ')' .
//            "\n\t\t\t\tFacing direction: \t" . $rover->getDirection()->getDirectionString() . "\n\n";
//
//        for ($c = $mars->getWidth(); $c >= 1; $c--)
//        {
//            echo "\t\t\t\t";
//            for ($i = 1; $i <= $mars->getHeight(); $i++)
//            {
//                echo ' ' . $marsField[$c][$i];
//            }
//            echo "\n";
//        }
//    }
//    public static function newRound(AbstractCommand $command, Mars $mars, Rover $rover): Rover
//    {
//        if (get_class($command) === CommandExit::class) {
//            exit("Thanks for playing! \t");
//        }
//        $newRover = Command::executeCommand($rover, $command, $mars);
//
//        if (($rover) && ($newRover)) {
//            if (Checker::isTheSameRover($rover, $newRover)) {
//                echo "\nWhoops, you hit an obstacle, try another command! \n";
//                self::showPosition($rover, $mars);
//                return $rover;
//            }
//
//            self::showPosition($newRover, $mars);
//            return $newRover;
//        }
//        return $rover;
//    }