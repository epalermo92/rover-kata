<?php

require_once 'vendor/autoload.php';

echo 'Game started! \n';
$width = readline("Inserire la larghezza della griglia ");
$height = readline("Inserire l'altezza della griglia ");
$x = readline("Inserisci l'ascissa iniziale ");
$y = readline("Inserisci l'ordinata iniziale ");
$startingDirection = readline("Inserisci la direzione iniziale: ");

//$checkObstacles = readline("Vuoi inserire ostacoli all'interno della griglia di gioco? (S|N) ");
//$i = 0;
//$c = 0;
//$obstacles = array();
//if ($checkObstacles === 'S'){
//    $i=readline("Quanti ostacoli vuoi inserire? ");
//    for ($c=0; $c<$i; $c++){
//        $obstacles[$i] = [
//            'x' => readline("Inserire la coordinata x dell'ostacolo: "),
//            'y' => readline("Inserire la coordinata y dell'ostacolo: "),
//            ];
//    }
//}
//
//if ($checkObstacles === 'N') {
//    $obstacles = array(null);
//}
$game = new \App\Functions\Game($width, $height, $x, $y, $startingDirection,/* $obstacles*/);

do{
    $command = readline('Inserire il comando da eseguire: ');
    if ($command!=='exit'){
        $game->play($command);
    }
}while($command !== 'exit');



