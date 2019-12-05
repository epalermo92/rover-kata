<?php declare(strict_types=1);

namespace App\Functions;

use App\Models\AbstractCommand;
use App\Models\CommandB;
use App\Models\CommandF;
use App\Models\CommandL;
use App\Models\CommandR;
use App\Models\DirectionE;
use App\Models\DirectionN;
use App\Models\DirectionS;
use App\Models\DirectionW;
use App\Models\Mars;
use App\Models\Rover;

class Command extends AbstractCommand
{
    public static function executeCommand(Rover $rover, AbstractCommand $command, Mars $mars):Rover
    {
        $newRover = $rover;
        if (($command->getCommand() === (new CommandF())->getCommand()) || ($command->getCommand() === (new CommandB())->getCommand())) {
            $newRover = self::move($rover, $mars, $command);
        } elseif (($command->getCommand() === (new CommandL())->getCommand()) || ($command->getCommand() === (new CommandR())->getCommand())) {
            $newRover = self::turn($rover, $command);
        }
        return self::checkRoverLimits($newRover, $mars);
    }

    protected static function turn(Rover $rover, AbstractCommand $command):Rover {
        if ($command->getCommand() === (new CommandL())->getCommand()) {
            switch ($rover->getDirection()->getDirection()) {
                case (new \App\Models\DirectionW)->getDirection():
                    return new Rover(PositionBuilder::build($rover->getPosition()->getX(), $rover->getPosition()->getY()), new DirectionS());
                    break;
                case (new \App\Models\DirectionS)->getDirection():
                    return new Rover(PositionBuilder::build($rover->getPosition()->getX(), $rover->getPosition()->getY()), new DirectionE());
                    break;
                case (new \App\Models\DirectionE)->getDirection():
                    return new Rover(PositionBuilder::build($rover->getPosition()->getX(), $rover->getPosition()->getY()), new DirectionN());
                    break;
                case (new \App\Models\DirectionN)->getDirection():
                    return new Rover(PositionBuilder::build($rover->getPosition()->getX(), $rover->getPosition()->getY()), new DirectionW());

            }
        }
        if ($command->getCommand() === (new CommandR())->getCommand()) {
            switch ($rover->getDirection()->getDirection()) {
                case (new \App\Models\DirectionS)->getDirection():
                    return new Rover(PositionBuilder::build($rover->getPosition()->getX(), $rover->getPosition()->getY()), new DirectionW());
                    break;
                case (new \App\Models\DirectionE)->getDirection():
                    return new Rover(PositionBuilder::build($rover->getPosition()->getX(), $rover->getPosition()->getY()), new DirectionS());
                    break;
                case (new \App\Models\DirectionN)->getDirection():
                    return new Rover(PositionBuilder::build($rover->getPosition()->getX(), $rover->getPosition()->getY()), new DirectionE());
                    break;
                case (new \App\Models\DirectionW)->getDirection():
                    return new Rover(PositionBuilder::build($rover->getPosition()->getX(), $rover->getPosition()->getY()), new DirectionN());
            }
        }
        return $rover;
    }

    protected static function move(Rover $rover, Mars $mars, AbstractCommand $command):Rover
    {
        $newRover = $rover;
        if ($command->getCommand() === (new CommandF())->getCommand()) {
            switch ($rover->getDirection()->getDirection()) {
                case (new DirectionN())->getDirection():
                    $newRover = new Rover(PositionBuilder::build($rover->getPosition()->getX(), $rover->getPosition()->getY() + 1), new DirectionN());
                    break;
                case (new DirectionS())->getDirection():
                    $newRover = new Rover(PositionBuilder::build($rover->getPosition()->getX(), $rover->getPosition()->getY() - 1), new DirectionS());
                    break;
                case (new DirectionE())->getDirection():
                    $newRover = new Rover(PositionBuilder::build($rover->getPosition()->getX() + 1, $rover->getPosition()->getY()), new DirectionE());
                    break;
                case (new DirectionW())->getDirection():
                    $newRover = new Rover(PositionBuilder::build($rover->getPosition()->getX() - 1, $rover->getPosition()->getY()), new DirectionW());
            }
        }
        if ($command->getCommand() === (new CommandB())->getCommand()) {
            switch ($rover->getDirection()->getDirection()) {
                case (new DirectionN())->getDirection():
                    $newRover = new Rover(PositionBuilder::build($rover->getPosition()->getX(), $rover->getPosition()->getY() - 1), new DirectionN());
                    break;
                case (new DirectionS())->getDirection():
                    $newRover = new Rover(PositionBuilder::build($rover->getPosition()->getX(), $rover->getPosition()->getY() + 1), new DirectionS());
                    break;
                case (new DirectionE())->getDirection():
                    $newRover = new Rover(PositionBuilder::build($rover->getPosition()->getX() - 1, $rover->getPosition()->getY()), new DirectionE());
                    break;
                case (new DirectionW())->getDirection():
                    $newRover = new Rover(PositionBuilder::build($rover->getPosition()->getX() + 1, $rover->getPosition()->getY()), new DirectionW());
            }
        }
//        if (self::meetsObstacles($newRover->getPosition(), $mars->getObstacles())){
//            return $rover;
//        }

        return $newRover;
    }

    public static function checkRoverLimits(Rover $rover, Mars $mars):Rover{
        if($rover->getPosition()->getX() < 1){
            return new Rover(PositionBuilder::build($mars->getWidth(), $rover->getPosition()->getY()), $rover->getDirection());
        }elseif($rover->getPosition()->getX() > $mars->getWidth()){
            return new Rover(PositionBuilder::build(1, $rover->getPosition()->getY()), $rover->getDirection());
        }elseif($rover->getPosition()->getY() < 1){
            return new Rover(PositionBuilder::build($rover->getPosition()->getX(), $mars->getHeight()), $rover->getDirection());
        }elseif($rover->getPosition()->getY() > $mars->getHeight()){
            return new Rover(PositionBuilder::build($rover->getPosition()->getX(), 1), $rover->getDirection());
        }

        return $rover;
    }

//    private static function meetsObstacles(Position $position, array $obstacles):bool {
//        foreach ($obstacles as $obstacle){
//            if($position === $obstacle)
//                return true;
//        }
//        return false;
//    }
}