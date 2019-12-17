<?php

use App\Functions\Builder\CommandBuilder;
use App\Functions\Builder\MarsBuilder;
use App\Functions\Builder\PositionBuilder;
use App\Functions\Builder\RoverBuilder;
use App\Functions\Checker\Checker;
use App\Functions\Game;
use App\Models\Mars;
use App\Models\Rover;
use FunctionalPHP\FantasyLand\Functor;
use Widmogrod\Monad\Either;
use function Widmogrod\Functional\bind;
use function Widmogrod\Functional\pipeline;
use function Widmogrod\Functional\valueOf;

require_once 'vendor/autoload.php';

$settings = Game::initGame();

/** @var Either\Either $r */
$r = pipeline(
    static function (array $obstacles): Either\Either {
        $obsRight = array_filter(
            $obstacles,
            static function (Either\Either $obs): bool {
                return $obs instanceof Either\Right;
            }
        );

        return count($obsRight) === count($obstacles)
            ? Either\right(
                array_map(
                    static function (Either\Either $either) {
                        return valueOf($either);
                    },
                    $obsRight
                )
            )
            : Either\left(new RuntimeException('fail parse obstacles'));
    },
    bind(
        static function (array $obstacles) use ($settings): Either\Either {
            return MarsBuilder::build(
                $settings['width'],
                $settings['height'],
                $obstacles
            );
        }
    ),
    bind(
        static function (Mars $mars) use ($settings) : Functor {
            return RoverBuilder::build(
                $settings['x'],
                $settings['y'],
                $settings['startingDirection']
            )->map(
                static function (Rover $rover) use ($mars): array {
                    return [
                        'mars' => $mars,
                        'rover' => $rover
                    ];
                });
        }
    ),
    bind(
        static function (array $parameters) use ($settings): Functor {
            return Either\right(array_map(
                static function (string $in): Either\Either {
                    return CommandBuilder::build($in);
                },
                $settings['commands']
            ))->map(
                static function (array $commands) use ($parameters) {
                    $parameters['commands'] = $commands;
                    return $parameters;
                }
            );
        }
    ),
    bind(
        static function (array $parameters) use ($settings): Functor {
            $commandRight = array_filter(
                $parameters['commands'],
                static function (Either\Either $obstacle): bool {
                    return $obstacle instanceof Either\Right;
                }
            );
            return count($commandRight) === count($settings['commands'])
                ? Either\right(
                    array_map(
                        static function (Either\Either $command) {
                            return valueOf($command);
                        },
                        $parameters['commands']
                    )
                )->map(
                    static function ($commands) use ($parameters) {
                        $parameters['commands'] = $commands;
                        return $parameters;
                    }
                )
                : Either\left(new RuntimeException('Command input error.'));
        }
    ),
    bind(
        static function (array $in): Either\Either {
            $newRover = Game::play($in['mars'], $in['rover'], $in['commands']);
            return Checker::isTheSameRover($newRover, $in['rover'])
                ? Either\right($newRover)
                : Either\left($in['rover']);
        }
    )
)(
    array_map(
        static function (array $in): Either\Either {
            return PositionBuilder::build($in['x'], $in['y']);
        },
        $settings['obstacles']
    )
);

$r->either(
    static function (RuntimeException $exception) {
        echo 'Whoops, you hit an obstacle!';
        echo $exception->getMessage();
    },
    static function (Rover $newRover) {
        Game::roverStatus($newRover);
    }
);



