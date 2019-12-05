<?php declare(strict_types=1);

namespace App\Functions;

use App\Models\AbstractCommand;
use App\Models\Mars;
use App\Models\Rover;

class Game
{
    public static function play(Mars $mars, Rover $rover):bool {
        self::showPosition($rover);
        do{
            echo "Inserire il comando da eseguire:\n\n F: Step Forward\n B: Step Backward\n R: Turn Right\n L: Turn Left\n\n";
            $command = CommandBuilder::build(readline());
            $rover = self::newRound($command, $mars, $rover);
        }while($command !== 'exit');
        return true;
    }

    public static function newRound(AbstractCommand $command, Mars $mars, Rover $rover):Rover {
        $newRover = Command::executeCommand($rover, $command, $mars);
//        if (Checker::areTheSame($rover, $newRover))
//        {
//            echo "\nOooops, sembra che tu abbia beccato un orstacolo, riprova con un'altro comando! \n";
//            self::showPosition($rover);
//            return $rover;
//        }
        self::showPosition($newRover);
        return $newRover;
    }

    public static function showPosition(Rover $rover){
        echo "\n\t\t\t\tActual Rover position: " .
            '(' .$rover->getPosition()->getX() . ', ' . $rover->getPosition()->getY() . ')' .
            "\n\t\t\t\tFacing direction: \t" . $rover->getDirection()->getDirection() . "\n\n";
    }
}