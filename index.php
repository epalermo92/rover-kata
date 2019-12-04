<?php

echo 'Game started! \n';
echo 'Insert starting position (x, y) and starting direction: ';

$width = readline("Inserire la larghezza della griglia ");
$height = readline("Inserire l'altezza della griglia ");
$x = readline("Inserisci l'ascissa iniziale ");
$y = readline("Inserisci l'ordinata iniziale ");
$startingDirection = readline("Inserisci la direzione iniziale: ");

$game = new \Models\Game($width, $height, $x, $y, $startingDirection);

do{
    $command = readline('Inserire il comando da eseguire: ');
    if ($command!=='exit'){
        $game->play($command);
    }
}while($command !== 'exit');



