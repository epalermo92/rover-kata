<?php declare(strict_types=1);

namespace App\Functions;

use App\Functions\Builder\DirectionBuilder;
use App\Functions\Builder\PositionBuilder;
use App\Functions\Checker\Checker;
use App\Models\Command\AbstractCommand;
use App\Models\Command\CommandB;
use App\Models\Command\CommandF;
use App\Models\Command\CommandL;
use App\Models\Command\CommandR;
use App\Models\Direction\AbstractDirection;
use App\Models\Direction\DirectionE;
use App\Models\Direction\DirectionN;
use App\Models\Direction\DirectionS;
use App\Models\Direction\DirectionW;
use App\Models\Mars;
use App\Models\Position;
use App\Models\Rover;
use function Widmogrod\Useful\match;

class Command extends AbstractCommand
{

    /**
     * @param Mars $mars
     * @param Rover $rover
     * @param AbstractCommand[] $commands
     * @return Rover
     */
    public static function executeCommand(Mars $mars, Rover $rover, array $commands): Rover
    {

        return array_reduce(
            $commands,
            static function (Rover $rover, AbstractCommand $command) use ($mars) : Rover {
                $patterns = [
                    CommandF::class => static function () use ($mars, $rover, $command) {
                        return Checker::checkRoverLimits(self::move($rover, $mars, $command), $mars);
                    },
                    CommandB::class => static function () use ($mars, $rover, $command) {
                        return Checker::checkRoverLimits(self::move($rover, $mars, $command), $mars);
                    },
                    CommandL::class => static function () use ($mars, $rover, $command) {
                        return Checker::checkRoverLimits(self::turn($rover, $command), $mars);
                    },
                    CommandR::class => static function () use ($mars, $rover, $command) {
                        return Checker::checkRoverLimits(self::turn($rover, $command), $mars);
                    },
                ];
                return match($patterns, $command);
            },
            $rover
        );
    }

    protected static function move(Rover $rover, Mars $mars, AbstractCommand $command): Rover
    {
        $combination = $command->getCommand() . $rover->getDirection()->getDirectionString();

        $direction = $rover->getDirection();
        $x = $rover->getPosition()->getX();
        $y = $rover->getPosition()->getY();

        $cases = [
            'FN' => [$x, $y + 1],
            'FS' => [$x, $y - 1],
            'BN' => [$x, $y - 1],
            'BS' => [$x, $y + 1],
            'FE' => [$x + 1, $y],
            'FW' => [$x - 1, $y],
            'BE' => [$x - 1, $y],
            'BW' => [$x + 1, $y],
        ];

        if ($mars->getObstacles() && self::meetsObstacles(new Position(...$cases[$combination]), $mars->getObstacles())) {
            return $rover;
        }

        return new Rover(new Position(...$cases[$combination]),$direction);
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