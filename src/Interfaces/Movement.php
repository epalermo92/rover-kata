<?php

use swkberlin\Interfaces\Position;


namespace swkberlin\Interfaces;


interface Movement {

    private function stepForward(Position $position, int $steps, string $direction):Position {
        $position->setX($position->getX() + $steps);
    }

    private function stepBackward(Position $position, int $steps):Position {
        $position->setX($position->getX() + $steps);
    }

}