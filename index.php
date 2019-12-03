<?php
    echo 'Game started! \n';
    echo 'Insert starting position (x, y) and starting direction: ';

    $x = $argv[1];
    $y = $argv[2];
    $startingDirection = $argv[3];

    echo $x . $y . $startingDirection;
