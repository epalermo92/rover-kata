<?php


namespace App\Functions\Checker;


class InputChecker
{

    public static function inputCommandFromTerminal(string $string = null):string
    {
        $check = false;

        do {
            $argument = readline($string);

            if (!in_array($argument, ['N', 'n', 'S', 's', 'E', 'e', 'W', 'w', 'F', 'f', 'B', 'b', 'R', 'r', 'L', 'l', 'N', 'n', 'Y', 'y', 'EXIT', 'exit'])) {
                echo "\n Wrong command.\nTry to insert an allowed one, according to the shown list.\t";
            }
            else
            {
                $check = true;
            }
        }while($check === false);

        return $argument;
    }

    public static function inputIntFromTerminal(string $string = null):int
    {
        $check = false;
        do
        {
            $argument = readline($string);

            if (!is_numeric($argument))
            {
                echo "\nInvalid input value, you can insert only positive numbers.\t";
            }
            else
            {
                $check = true;
            }
        }while($check === false);

        return (int)$argument;
    }

    public static function inputDirectionFromTerminal(string $string = null):string
    {
        $check = false;
        do
        {
            $argument = readline($string);

            if (!in_array($argument, ['N', 'n', 'S', 's', 'E', 'e', 'W', 'w'])) {
                {
                    echo "\nInvalid direction.\nYou can insert only positive numbers.\t";
                }
            }
            else
            {
                $check = true;
            }
        }while($check === false);

        return $argument;
    }
}