<?php

use App\Functions\Builder\CommandBuilder;
use App\Functions\Builder\MarsBuilder;
use App\Functions\Builder\PositionBuilder;
use App\Functions\Builder\RoverBuilder;
use App\Functions\Game;
use App\Models\Mars;
use App\Models\Rover;
use FunctionalPHP\FantasyLand\Functor;
use Widmogrod\Monad\Either;
use function Widmogrod\Functional\bind;
use function Widmogrod\Functional\pipeline;
use const Widmogrod\Functional\reThrow;

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
                        return $either->extract();
                    },
                    $obsRight
                )
            )
            : Either\left(new \RuntimeException('fail parse obstacles'));
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
        static function(Mars $mars) use ($settings) : Functor {
            return RoverBuilder::build(
                $settings['x'],
                $settings['y'],
                $settings['startingDirection']
            )->map(
                static function (Rover $rover) use ($mars): array {
                return [$mars, $rover];
            });
        }
    ),
    bind(
        static function (array $parameters) use ($settings): array {
            $parameters[] = array_map(
                static function (array $in): Either\Either {
                    return CommandBuilder::build(...$in);
                },
                $settings['commands']
            );
            return $parameters;
        }
    ),
    bind(
      static function (array $parameters) use ($settings):Either\Either {
          $commandRight = array_filter(
              $parameters[array_key_last($parameters)],
              static function (Either\Either $obstacle):bool {
                  return $obstacle instanceof Either\Right;
              }
          );
          return count($commandRight) === count($settings['commands'])
              ?Either\Right(
                  static function () use ($parameters) {
                      $cmds = array_map(
                          static function (Either\Right $commands):Either\Right {
                              return $commands->extract();
                          },
                          $parameters[array_key_last($parameters)]
                      );
                      $parameters[array_key_last($parameters)] = $cmds;
                      return $parameters;
                  }
              )
              :Either\Left(new RuntimeException('Command input error.'));
      }
    ),
    bind(
        static function (Either\Either $in) {
            $array = $in->extract();
            Game::play(...$array);
        }
    )
)(
    array_map(
        static function (array $in): Either\Either {
            return PositionBuilder::build(...$in);
        },
        $settings['obstacles']
    )
);

$r->either(
    reThrow,
    function () {
        echo 'ok';
    }
);



