<?php

use App\Functions\Builder\CommandBuilder;
use App\Functions\Builder\MarsBuilder;
use App\Functions\Builder\PositionBuilder;
use App\Functions\Builder\RoverBuilder;
use App\Functions\Checker\Checker;
use App\Functions\GamePlay;
use App\Models\Game;
use App\Models\Mars;
use App\Models\Result;
use App\Models\Rover;
use FunctionalPHP\FantasyLand\Functor;
use Widmogrod\Monad\Either;
use function Widmogrod\Functional\bind;
use function Widmogrod\Functional\map;
use function Widmogrod\Functional\pipeline;
use function Widmogrod\Functional\valueOf;
use function Widmogrod\Monad\IO\putStrLn;

require_once 'vendor/autoload.php';

$settings = GamePlay::initGame();

/** @var Either\Either $pipelineResult */
$pipelineResult = pipeline(
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
                static function (Rover $rover) use ($mars): Game {
                    return new Game($mars, $rover, null);
                });
        }
    ),
    bind(
        static function (Game $game) use ($settings): Functor {
            return Either\right(array_map(
                static function (string $in): Either\Either {
                    return CommandBuilder::build($in);
                },
                $settings['commands']
            ))->map(
                static function (array $commands) use ($game) {
                    return new Game($game->getMars(), $game->getRover(), $commands);
                }
            );
        }
    ),
    bind(
        static function (Game $game) use ($settings): Functor {
            $commandRight = array_filter(
                $game->getCommands(),
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
                        $game->getCommands()
                    )
                )->map(
                    static function ($commands) use ($game) {
                        return new Game($game->getMars(), $game->getRover(), $commands);
                    }
                )
                : Either\left(new RuntimeException('Command input error.'));
        }
    ),
    map(
        static function (Game $game): Result {
            return GamePlay::exec($game);
        }
    )
)(
    array_map(
        static function (array $inputData): Either\Either {
            return PositionBuilder::build($inputData['x'], $inputData['y']);
        },
        $settings['obstacles']
    )
);

putStrLn($pipelineResult->either(
    static function (RuntimeException $exception): string {
        return $exception->getMessage();
    },
    static function (Result $result): string {
        return GamePlay::serializeResult($result);
    }
))->run();




