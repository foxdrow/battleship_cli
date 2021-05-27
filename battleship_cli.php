<?php

function battleship($x, $y, $coords = [])
{
    display($x, $y, $coords);
    echo "Player 1, place your 2 ships :\n";
    $coords = readCli($x, $y, $coords, 2, "Player 1");
    echo "Player 2, place your 2 ships :\n";
    $coords = readCli($x, $y, $coords, 2, "Player 2");
    while(!empty($coords)){
        echo "Player 1, launch your attack :\n";
        $coords = readCli($x, $y, $coords, 2, "Player 1");
        echo "Player 2, launch your attack :\n";
        $coords = readCli($x, $y, $coords, 2, "Player 2");
    }
}

function display($x, $y, $coords)
{
    if ($x !== 0 && $y !== 0) {
        for ($i = 0; $i < $y; $i++) {
            $z = 0;
            while ($z < $x) {
                echo "+---";
                $z++;
                if ($z == $x) {
                    echo "+";
                }
            }
            echo "\n";
            for ($o = 0; $o < $x; $o++) {
                if (in_array([$o, $i], $coords, true)) {
                    echo "| X ";
                } else {
                    echo '|   ';
                }
            }
            echo "|\n";
            if ($i == $y - 1) {
                $z = 0;
                while ($z < $x) {
                    echo "+---";
                    $z++;
                    if ($z == $x) {
                        echo "+";
                    }
                }
            }
        }
        echo "\n";
    }
}

function readCli($x, $y, $coords, $nt = 50, $info = "")
{
    while ($nt > 0) {
        $info == "Player 1" ? $opponent = "Player 2" : $opponent = "Player 1";
        echo $info . " $> ";

        $line = trim(fgets(STDIN));
        $ar = explode(" ", $line);

        if ($ar[0] == "query") {

            $na = explode(',', $ar[1]);
            $n1 = substr($na[0], 1);
            $n2 = substr($na[1], 0, -1);
            $n1 = (int)$n1;
            $n2 = (int)$n2;
            if (in_array([$n1, $n2], $coords, true)) {
                echo "$info, you touched a boat of $opponent !\n";
                $nt--;
            } else {
                echo "$info, you didn't touch anything.\n";
                $nt--;
            }
        }
        if ($ar[0] == "add") {

            $na = explode(',', $ar[1]);
            $n1 = substr($na[0], 1);
            $n2 = substr($na[1], 0, -1);
            $n1 = (int)$n1;
            $n2 = (int)$n2;

            if (in_array([$n1, $n2], $coords, true)) {
                echo "A cross already exists at this location\n";
            } else {
                $coords[] = [$n1, $n2];
                $nt--;
            }
        }
        if ($ar[0] == "remove") {

            $na = explode(',', $ar[1]);
            $n1 = substr($na[0], 1);
            $n2 = substr($na[1], 0, -1);
            $n1 = (int)$n1;
            $n2 = (int)$n2;

            if (in_array([$n1, $n2], $coords, true)) {
                $tempco = [];
                foreach ($coords as $key => $val) {
                    if ($val !== [$n1, $n2]) {
                        $tempco[] = $val;
                    }
                }
                $coords = $tempco;
            } else {
                echo "No cross exists at this location\n";
            }
        }
        if ($ar[0] == "display") {
            display($x, $y, $coords);
        }
    }
    return $coords;
}

//battleship(4, 5);
