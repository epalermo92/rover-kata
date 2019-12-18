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

class Command extends AbstractCommand
{

    /**
     * @param Mars $mars
     * @param Rover $rover
     * @param AbstractCommand $command
     * @return Result
     */
    public static function executeCommand(Mars $mars, Rover $rover, AbstractCommand $command): Result
    {
        if ($command instanceof CommandF || $command instanceof CommandB) {
            $result = self::move($rover, $mars, $command);
            if (!Checker::isTheSamePosition($rover->getPosition(), $result->getRover()->getPosition())) {
                return $result;
            }
            return new Result($rover, $mars, true);
        }

        return self::turn($mars, $rover, $command);

    }

    protected static function move(Rover $rover, Mars $mars, AbstractCommand $command): Result
    {
        $combination = $command->getCommand() . $rover->getDirection()->getDirectionString();

        $cases = [
            'FN' => [0, 1],
            'BS' => [0, 1],
            'FS' => [0, -1],
            'BN' => [0, -1],
            'BW' => [1, 0],
            'FE' => [1, 0],
            'FW' => [-1, 0],
            'BE' => [-1, 0],
        ];

        $x = $rover->getPosition()->getX() + $cases[$combination][0];
        $y = $rover->getPosition()->getY() + $cases[$combination][1];

        foreach ($mars->getObstacles() as $obstacle) {
            if ($mars->getObstacles() && Checker::isTheSamePosition(new Position($x, $y), $obstacle)) {
                return new Result($rover, $mars, true);
            }
        }

        return new Result (new Rover(new Position($x, $y), $rover->getDirection()), $mars, false);
    }

    protected static function turn(Mars $mars, Rover $rover, AbstractCommand $command): Result
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

        return new Result(new Rover(new Position($rover->getPosition()->getX(), $rover->getPosition()->getY()), new $relations[get_class($rover->getDirection())]), $mars, false);
    }
}