<?php

use App\Functions\Builder\DirectionBuilder;
use App\Functions\Builder\MarsBuilder;
use App\Functions\Builder\PositionBuilder;
use App\Functions\Game;
use App\Models\Position;
use App\Models\Rover;

require_once 'vendor/autoload.php';

$settings = Game::setGame();
Game::play(
    MarsBuilder::build($settings['width'], $settings['height'], Game::checkAndSetObstacles()),
    new Rover(
        PositionBuilder::build(
            $settings['x'],
            $settings['y'],
            )
            ->either(
                static function (string $string) {
                    echo $string;
                },
                static function (Position $position) {
                    return $position;
                }),
        DirectionBuilder::build($settings['startingDirection']))
);