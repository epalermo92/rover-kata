<?php declare(strict_types=1);

namespace App\Functions;

use App\Functions\Checker\Checker;
use App\Models\Command\AbstractCommand;
use App\Models\Command\CommandB;
use App\Models\Command\CommandF;
use App\Models\Command\CommandR;
use App\Models\Direction\DirectionE;
use App\Models\Direction\DirectionN;
use App\Models\Direction\DirectionS;
use App\Models\Direction\DirectionW;
use App\Models\Mars;
use App\Models\Position;
use App\Models\Result;
use App\Models\Rover;
use Widmogrod\Useful\PatternNotMatchedError;

class Command extends AbstractCommand
{

    /**
     * @param Mars $mars
     * @param Rover $rover
     * @param AbstractCommand $command
     * @return Result
     * @throws PatternNotMatchedError
     */
    public static function executeCommand(Mars $mars, Rover $rover, AbstractCommand $command): Result
    {
        if ($command instanceof CommandF || $command instanceof  CommandB){
            $newRover = Checker::checkRoverLimits(self::move($rover, $mars, $command), $mars);
            if (!Checker::isTheSamePosition($rover->getPosition(), $newRover->getPosition())){
                return new Result($newRover, $mars, false);
            }
            return new Result($rover, $mars, true);
        }

        return new Result(self::turn($rover, $command), $mars, false);

    }

    protected static function move(Rover $rover, Mars $mars, AbstractCommand $command): Rover
    {
        $combination = $command->getCommand() . $rover->getDirection()->getDirectionString();

        $cases = [
            'FN' => [0, 1],
            'BS' => [0, 1],
            'FS' => [0, - 1],
            'BN' => [0, - 1],
            'BW' => [1, 0],
            'FE' => [1, 0],
            'FW' => [- 1, 0],
            'BE' => [- 1, 0],
        ];

        if ($mars->getObstacles() && self::meetsObstacles(new Position(...$cases[$combination]), $mars->getObstacles())) {
            return $rover;
        }

        return new Rover(new Position(
            $rover->getPosition()->getX() + $cases[$combination][0],
            $rover->getPosition()->getY() + $cases[$combination][1]),
            $rover->getDirection());
    }

    protected static function turn(Rover $rover, AbstractCommand $command): Rover
    {
        $relations = [
            DirectionW::class => DirectionS::class,
            DirectionS::class => DirectionE::class,
            DirectionE::class => DirectionN::class,
            DirectionN::class => DirectionW::class,
        ];

        if (get_class($command) === CommandR::class) {
            $relations = array_flip($relations);
        }

        return new Rover(new Position($rover->getPosition()->getX(), $rover->getPosition()->getY()), new $relations[get_class($rover->getDirection())]);
    }

    private static function meetsObstacles(Position $position, array $obstacles): bool
    {
        foreach ($obstacles as $obstacle) {
            if (Checker::isTheSamePosition($position, $obstacle)) {
                return true;
            }
        }
        return false;
    }
}