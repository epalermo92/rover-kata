<?php declare(strict_types=1);

namespace App\Functions;

use App\Functions\Builder\DirectionBuilder;
use App\Functions\Builder\PositionBuilder;
use App\Functions\Checker\Checker;
use App\Models\AbstractCommand;
use App\Models\AbstractDirection;
use App\Models\CommandB;
use App\Models\CommandF;
use App\Models\CommandL;
use App\Models\CommandR;
use App\Models\DirectionE;
use App\Models\DirectionN;
use App\Models\DirectionS;
use App\Models\DirectionW;
use App\Models\Mars;
use App\Models\Position;
use App\Models\Rover;
use RuntimeException;

class Command extends AbstractCommand
{

    public static function executeCommand(Rover $rover, AbstractCommand $command, Mars $mars): Rover
    {
        switch (get_class($command)) {
            case CommandB::class:
            case CommandF::class:
                return Checker::checkRoverLimits(self::move($rover, $mars, $command), $mars);
                break;
            case CommandL::class:
            case CommandR::class:
                return Checker::checkRoverLimits(self::turn($rover, $command), $mars);
                break;
            default:
                throw  new RuntimeException('Invalid Command.');
                break;
        }
    }

    protected static function move(Rover $rover, Mars $mars, AbstractCommand $command): Rover
    {
        $case = $command->getCommand() . $rover->getDirection()->getDirectionString();
        $delta = self::coordinatesCombination($case);

        $newRover = [
            'FN' => new Rover(self::buildPosition($rover->getPosition()->getX(), $rover->getPosition()->getY() + $delta), self::buildDirection($case[1])),
            'FS' => new Rover(self::buildPosition($rover->getPosition()->getX(), $rover->getPosition()->getY() + $delta), self::buildDirection($case[1])),
            'BN' => new Rover(self::buildPosition($rover->getPosition()->getX(), $rover->getPosition()->getY() + $delta), self::buildDirection($case[1])),
            'BS' => new Rover(self::buildPosition($rover->getPosition()->getX(), $rover->getPosition()->getY() + $delta), self::buildDirection($case[1])),
            'FE' => new Rover(self::buildPosition($rover->getPosition()->getX() + $delta, $rover->getPosition()->getY()), self::buildDirection($case[1])),
            'FW' => new Rover(self::buildPosition($rover->getPosition()->getX() + $delta, $rover->getPosition()->getY()), self::buildDirection($case[1])),
            'BE' => new Rover(self::buildPosition($rover->getPosition()->getX() + $delta, $rover->getPosition()->getY()), self::buildDirection($case[1])),
            'BW' => new Rover(self::buildPosition($rover->getPosition()->getX() + $delta, $rover->getPosition()->getY()), self::buildDirection($case[1])),
        ];

        if ($mars->getObstacles() && self::meetsObstacles($newRover[$case]->getPosition(), $mars->getObstacles())) {
            return $rover;
        }

        return $newRover[$case];
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

        $newRover = [
            DirectionW::class => new Rover(self::buildPosition($rover->getPosition()->getX(), $rover->getPosition()->getY()), new $relations[get_class(new DirectionW())]),
            DirectionS::class => new Rover(self::buildPosition($rover->getPosition()->getX(), $rover->getPosition()->getY()), new $relations[get_class(new DirectionS())]),
            DirectionE::class => new Rover(self::buildPosition($rover->getPosition()->getX(), $rover->getPosition()->getY()), new $relations[get_class(new DirectionE())]),
            DirectionN::class => new Rover(self::buildPosition($rover->getPosition()->getX(), $rover->getPosition()->getY()), new $relations[get_class(new DirectionN())]),
        ];

        return $newRover[get_class($rover->getDirection())];
    }

    public static function coordinatesCombination(string $case): int
    {
        $caseSelector = [
            'FN' => 1,
            'FE' => 1,
            'BS' => 1,
            'BW' => 1,
            'FS' => -1,
            'FW' => -1,
            'BN' => -1,
            'BE' => -1,
        ];

        return $caseSelector[$case];
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

    public static function buildPosition(int $x, int $y):Position{
        return PositionBuilder::build(
            $x,
            $y,
            )
            ->either(
                static function (\Exception $e) {
                    echo 'Input Error.' . $e->getMessage();
                },
                static function (Position $position){
                    return $position;
                });
    }

    public static function buildDirection(string $direction):AbstractDirection{
        return DirectionBuilder::build(
            $direction
            )
            ->either(
                static function (\Exception $e) {
                    echo 'Input Error.' . $e->getMessage();
                },
                static function (AbstractDirection $direction){
                    return $direction;
                });
    }
}