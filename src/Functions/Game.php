<?php declare(strict_types=1);

namespace App\Functions;

use App\Functions\Builder\CommandBuilder;
use App\Functions\Builder\PositionBuilder;
use App\Models\AbstractCommand;
use App\Models\CommandExit;
use App\Models\CommandNo;
use App\Models\Mars;
use App\Models\Rover;

class Game
{
    public static function setGame(): array
    {
        echo "\nGame started!\n\nInsert Mars width:\t";
        $settings['width'] = InputChecker::inputIntFromTerminal();
        echo "\nInsert Mars height:\t";
        $settings['height'] = InputChecker::inputIntFromTerminal();
        echo "\nInsert starting x:\t\t";
        $settings['x'] = InputChecker::inputIntFromTerminal();
        echo "\nInsert starting y:\t\t";
        $settings['y'] = InputChecker::inputIntFromTerminal();
        echo "\nInsert starting direction:\t";
        $settings['startingDirection'] = InputChecker::inputDirectionFromTerminal();

        return $settings;
    }

    public static function play(Mars $mars, Rover $rover): bool
    {
        self::showPosition($rover);

        do {

            echo "Insert the command to execute:\n\n F: Step Forward\n B: Step Backward\n R: Turn Right\n L: Turn Left\n\n";
            $command = CommandBuilder::build(InputChecker::inputCommandFromTerminal())
            ->either(
                static function ($string) {
                    throw new \RuntimeException($string);
                },
                static function ($command) {
                    return $command;
                }
            );
            $rover = self::newRound($command, $mars, $rover);
        } while ($command !== 'exit');

        return true;
    }

    public static function showPosition(Rover $rover)
    {
        echo "\n\t\t\t\tActual Rover position: " .
            '(' . $rover->getPosition()->getX() . ', ' . $rover->getPosition()->getY() . ')' .
            "\n\t\t\t\tFacing direction: \t" . $rover->getDirection()->getDirectionString() . "\n\n";
    }

    public static function newRound(AbstractCommand $command, Mars $mars, Rover $rover): Rover
    {
        if (get_class($command) === CommandExit::class) {
            exit("Thanks for playing! \t");
        }
        $newRover = Command::executeCommand($rover, $command, $mars);

        if (($rover) && ($newRover)) {
            if (Checker::isTheSameRover($rover, $newRover)) {
                echo "\nWhoops, you hit an obstacle, try another command! \n";
                self::showPosition($rover);
                return $rover;
            }

            self::showPosition($newRover);
            return $newRover;
        }
        return $rover;
    }

    public static function checkAndSetObstacles(): array
    {
        echo "\n";
        echo "Do you want to put any obstacle on Mars? (Y|N):\t";
        $command = CommandBuilder::build(InputChecker::inputCommandFromTerminal())
            ->either(
                static function ($string) {
                    throw new \RuntimeException($string);
                },
                static function ($command) {
                    return $command;
                }
            );
        $obstacles = array();
        if (get_class($command) === CommandNo::class) {
            return [];
        }
        echo "\nHow many obstacles ? ";
        $i = InputChecker::inputIntFromTerminal();
        echo "\n";
        for ($c = 0; $c < $i; $c++) {
            $x = InputChecker::inputIntFromTerminal('Insert ' . ($c + 1) . "° obstacle's x: ");
            $y = InputChecker::inputIntFromTerminal('Insert ' . ($c + 1) . "° obstacle's y: ");

            $obstacles[] = Command::buildPosition(
                $x,
                $y,
                );
            echo "\n";
        }
        return $obstacles;
    }
}