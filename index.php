<?php

echo 'Game started! \n';
echo 'Insert starting position (x, y) and starting direction: ';

$x = readline("Inserisci l'ascissa iniziale \n");
$y = readline("Inserisci l'ordinata iniziale \n");
$startingDirection = readline("Inserisci la direzione iniziale: \n");
$command = readline("Inserisci il primo comando che vuoi eseguire: \n");

$game = new \src\Models\Game($x, $y, $startingDirection);

do{
    echo 'Inserire il comando da eseguire: ';
    $command = readline();
    if ($command!=='exit'){
        $game->play($command);
    }
}while($command !== 'exit');



