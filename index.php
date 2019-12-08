<?php

use App\Functions\DirectionBuilder;
use App\Functions\Game;
use App\Functions\MarsBuilder;
use App\Functions\PositionBuilder;
use App\Models\Rover;

require_once 'vendor/autoload.php';

$settings = Game::setGame();
Game::play(
    MarsBuilder::build($settings['width'], $settings['height'], Game::checkAndSetObstacles()),
    new Rover(PositionBuilder::build($settings['x'], $settings['y']),
        DirectionBuilder::build($settings['startingDirection']))
    );
