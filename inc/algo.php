<?php

$summr = 6601;
$steps = [];

$notes = [
    '5000' => '30',
    '2000' => '30',
    '500' => '10',
    '200' => '30',
];

$withdraw = [];

function fill($draw, $note){
    global $summr;
    global $notes;

    foreach($notes as $nom => $qnt){
        if(!isset($draw[$nom]))
            $draw[$nom] = 0;
    }

    $diff = ($draw != $notes) ? diff($draw) : $notes;

    foreach($diff as $nom => &$qnt){
        if($nom == $note)
            continue;
        while((getSumm($draw) + $nom <= $summr) && $qnt > 0){
            $qnt--;
            $draw[$nom]++;
        }
    }

    return $draw;
}
function diff($fill, $diff = array()){
    global $notes;

    foreach($notes as $nom => $qnt){
        if(!isset($fill[$nom])) $fill[$nom] = 0;
        $diff[$nom] = $notes[$nom] - $fill[$nom];
    }
    return $diff;
}
function getLowestNote($notes){
    $i = 1;
    $cnt = count($notes);
    foreach($notes as $nom => $qnt){
        if($i != $cnt && $qnt != 0){
            $res = $nom;
        }
        $i++;
    }
    return $res;
}
function deriveOneNote($draw, $note){
    $mark = false;
    foreach($draw as $nom => &$qnt){
        if($mark == true)
            $qnt = 0;

        if($nom == $note){
            $qnt--;
            $mark = true;
        }

    }
    return $draw;
}
function getSumm($notes){
    $summ = 0;
    foreach($notes as $nom => $qnt){
        $summ += $nom * $qnt;
    }
    return $summ;
}

function recordStep($step){
    global $steps;
    $steps[] = $step;
}

function recurse($draw, $note = false){
    global $summr;
    global $steps;
    $fill = fill($draw, $note);

    if(in_array($fill, $steps)){
//        echo "fail";
        return false;
    }
    recordStep($fill);

    if(getSumm($fill) == $summr){
//        echo "done";
        return $fill;
    }

    $note = getLowestNote($fill);
    $fill = deriveOneNote($fill, $note);

    return recurse($fill, $note, 3);
}

//$res = recurse($withdraw, false, 1);

$t1 = time();

for($a = 0; $a < 1000; $a++){
    $summr = (rand(50, 200) * 100);
    $res = recurse($withdraw, false, 1);
//    if($res)
//    var_dump($res, $summr);
}

$t2 = time();

echo '<pre>';
var_dump($t2 - $t1);
echo '</pre>';