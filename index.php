<?php

require_once 'vendor/autoload.php';

$settings = \App\Functions\Game::setGame();
\App\Functions\Game::play(
    \App\Functions\MarsBuilder::build($settings['width'], $settings['height'],\App\Functions\Game::checkAndSetObstacles()),
    new \App\Models\Rover(\App\Functions\PositionBuilder::build($settings['x'],$settings['y']),
        \App\Functions\DirectionBuilder::build($settings['startingDirection'])));