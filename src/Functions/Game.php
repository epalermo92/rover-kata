<?php declare(strict_types=1);

namespace App\Functions;

use App\Models\AbstractCommand;
use App\Models\CommandExit;
use App\Models\Mars;
use App\Models\Rover;

class Game
{
    public static function setGame():array
    {
        echo "\nGame started!\n\nInsert Mars width:\t";
        $settings['width'] = readline();
        echo "\nInsert Mars height:\t";
        $settings['height'] = readline();
        echo "\nInsert starting x:\t\t";
        $settings['x'] = readline();
        echo "\nInsert starting y:\t\t";
        $settings['y'] = readline();
        echo "\nInsert starting direction:\t";
        $settings['startingDirection'] = readline();

        return $settings;
    }

    public static function play(Mars $mars, Rover $rover):bool
    {
        self::showPosition($rover);

        do{
            echo "Insert the command to execute:\n\n F: Step Forward\n B: Step Backward\n R: Turn Right\n L: Turn Left\n\n";
            $command = CommandBuilder::build(readline());
            $rover = self::newRound($command, $mars, $rover);
        }while($command !== 'exit');

        return true;
    }

    public static function newRound(AbstractCommand $command, Mars $mars, Rover $rover):Rover
    {
        if (get_class($command) === CommandExit::class)
        {
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
    }

    public static function showPosition(Rover $rover)
    {
        echo "\n\t\t\t\tActual Rover position: " .
            '(' .$rover->getPosition()->getX() . ', ' . $rover->getPosition()->getY() . ')' .
            "\n\t\t\t\tFacing direction: \t" . $rover->getDirection()->getDirectionString() . "\n\n";
    }

    public static function checkAndSetObstacles():array
    {
        echo "\n";
        echo "Do you want to put any obstacle on Mars? (S|N):\t";
        $checkObstacles = readline();
        $i = 0;
        $c = 0;
        $obstacles = array();
        if ($checkObstacles === 'S') {
            echo "\nHow many? ";
            $i = readline();
            echo "\n";
            for ($c = 0; $c < $i; $c++) {
                $obstacles[] = \App\Functions\PositionBuilder::build(
                    (int)readline("Insert" . ($c + 1) . "° obstacle's x: "),
                    (int)readline("Insert" . ($c + 1) . "° obstacle's y: "),
                    );
                echo "\n";
            }
            return $obstacles;
        }
            return array(null);
    }
}