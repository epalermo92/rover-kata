<?php

require_once 'vendor/autoload.php';

echo "\nGame started! \n\nInserire la larghezza della griglia:\t";
$width = readline();
echo "\nInserire l'altezza della griglia:\t";
$height = readline();
echo "\nInserisci l'ascissa iniziale:\t";
$x = readline();
echo "\nInserisci l'ordinata iniziale:\t";
$y = readline();
echo "\nInserisci la direzione iniziale:\t";
$startingDirection = readline();

//$checkObstacles = readline("Vuoi inserire ostacoli all'interno della griglia di gioco? (S|N) ");
//$i = 0;
//$c = 0;
//$obstacles = array();
//if ($checkObstacles === 'S'){
//    $i=readline("Quanti ostacoli vuoi inserire? ");
//    for ($c=0; $c<$i; $c++){
//        $x = readline("Inserire la coordinata x dell'ostacolo: ");
//        $y = readline("Inserire la coordinata y dell'ostacolo: ");
//        $obstacles[$i] = new \App\Models\Position($x, $y);
// }
//}
//
//if ($checkObstacles === 'N') {
//    $obstacles = array(null);
//}
$game = new \App\Functions\Game($width, $height, $x, $y, $startingDirection,/* $obstacles*/);
$game->showPosition();
do{
    echo "Inserire il comando da eseguire:\n\n F: Step Forward\n B: Step Backward\n R: Turn Right\n L: Turn Left\n\n";
    $command = readline();
    if ($command!=='exit'){
        $game->play($command);
    }
}while($command !== 'exit');



