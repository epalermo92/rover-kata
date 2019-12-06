<?php declare(strict_types=1);

namespace App\Functions;

use App\Models\AbstractCommand;
use App\Models\Mars;
use App\Models\Rover;

class Game
{
    public static function setGame():array
    {
        echo "\nGame started!\n\nInserire la larghezza della griglia:\t";
        $settings['width'] = readline();
        echo "\nInserire l'altezza della griglia:\t";
        $settings['height'] = readline();
        echo "\nInserisci l'ascissa iniziale:\t\t";
        $settings['x'] = readline();
        echo "\nInserisci l'ordinata iniziale:\t\t";
        $settings['y'] = readline();
        echo "\nInserisci la direzione iniziale:\t";
        $settings['startingDirection'] = readline();

        return $settings;
    }

    public static function play(Mars $mars, Rover $rover):bool
    {
        self::showPosition($rover);

        do{
            echo "Inserire il comando da eseguire:\n\n F: Step Forward\n B: Step Backward\n R: Turn Right\n L: Turn Left\n\n";
            $command = CommandBuilder::build(readline());
            $rover = self::newRound($command, $mars, $rover);
        }while($command !== 'exit');

        return true;
    }

    public static function newRound(AbstractCommand $command, Mars $mars, Rover $rover):Rover
    {
        $newRover = Command::executeCommand($rover, $command, $mars);

        if (($rover) && ($newRover)) {
            if (Checker::isTheSameRover($rover, $newRover)) {
                echo "\nOooops, sembra che tu abbia beccato un ostacolo, riprova con un'altro comando! \n";
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
            "\n\t\t\t\tFacing direction: \t" . $rover->getDirection()->getDirection() . "\n\n";
    }

    public static function checkAndSetObstacles():array
    {
        echo "\n";
        echo "Vuoi inserire ostacoli all'interno della griglia di gioco? (S|N):\t";
        $checkObstacles = readline();
        $i = 0;
        $c = 0;
        $obstacles = array();
        if ($checkObstacles === 'S') {
            echo "\nQuanti ostacoli vuoi inserire? ";
            $i = readline();
            echo "\n";
            for ($c = 0; $c < $i; $c++) {
                $obstacles[] = \App\Functions\PositionBuilder::build(
                    (int)readline('Inserire la coordinata x del ' . ($c + 1) . '° ostacolo: '),
                    (int)readline('Inserire la coordinata y del ' . ($c + 1) . '° ostacolo: '),
                    );
                echo "\n";
            }
            return $obstacles;
        }
            return array(null);
    }
}