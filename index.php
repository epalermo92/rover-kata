<?php

require_once 'vendor/autoload.php';

echo "\nGame started!\n";
echo "\nInserire la larghezza della griglia:\t";
$width = readline();
echo "\nInserire l'altezza della griglia:\t";
$height = readline();
echo "\nInserisci l'ascissa iniziale:\t\t";
$x = readline();
echo "\nInserisci l'ordinata iniziale:\t\t";
$y = readline();
echo "\nInserisci la direzione iniziale:\t";
$startingDirection = readline();
//echo "Vuoi inserire ostacoli all'interno della griglia di gioco? (S|N):\t";
//$checkObstacles = readline();
//$i = 0;
//$c = 0;
//$obstacles = array();
//if ($checkObstacles === 'S'){
//    $i=readline("Quanti ostacoli vuoi inserire? ");
//    for ($c=0; $c<$i; $c++){
//        $obstacles[$i] = \App\Functions\PositionBuilder::build(
//            readline("Inserire la coordinata x dell'ostacolo: "),
//            readline("Inserire la coordinata y dell'ostacolo: "),
//        );
//    }
//}
//if ($checkObstacles === 'N') {
//    $obstacles = array(null);
//}

if(\App\Functions\Game::play(\App\Functions\MarsBuilder::build($width, $height/*,$obstacles*/), new \App\Models\Rover(\App\Functions\PositionBuilder::build($x,$y), \App\Functions\DirectionBuilder::build($startingDirection))))
{
    exit(0);
}
