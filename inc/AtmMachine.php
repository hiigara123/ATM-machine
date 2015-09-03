<?php

namespace ATM;

class AtmMachine {
    public $summ_requested = 11110;
    private $steps = [];
    public $notes = [
        '5000' => '3',
        '2000' => '3',
        '500' => '1',
        '200' => '3',
        '50' => '1',
        '20' => '3',
    ];

    public function __construct()
    {
        if(isset($_GET['summ_requested']))
            $this->summ_requested = $_GET['summ_requested'];
    }

    /* main method */
    public function recurse($draw = false, $note = false)
    {
        /* fill array with biggest possible banknotes */
        $fill = $this->fill($draw, $note);

        if(in_array($fill, $this->steps))
            return false;

        $this->recordStep($fill);

        /* check if it already reached the requested summ */
        if($this->getSumm($fill) == $this->summ_requested)
            return $this->steps;

        /* if not, find the second lowest note and derive one from array  */
        $note = $this->getLowestNote($fill);
        $fill = $this->deriveOneNote($fill, $note);

        /* repeat until summ is reached or recursion become cycled */
        return $this->recurse($fill, $note, 3);
    }

    private function fill($draw, $note)
    {
        foreach($this->notes as $nom => $qnt){
            if(!isset($draw[$nom]))
                $draw[$nom] = 0;
        }

        $diff = ($draw != $this->notes) ? $this->diff($draw) : $this->notes;
        $note = $note ? $note : 0;

        foreach($diff as $nom => &$qnt){
            if($note != 0 && $nom > $note)
                continue;
            if($nom == $note)
                continue;
            while(($this->getSumm($draw) + $nom <= $this->summ_requested) && $qnt > 0){
                $qnt--;
                $draw[$nom]++;
            }
        }
        return $draw;
    }

    private function diff($fill, $diff = array())
    {
        foreach($this->notes as $nom => $qnt){
            if(!isset($fill[$nom])) $fill[$nom] = 0;
            $diff[$nom] = $this->notes[$nom] - $fill[$nom];
        }
        return $diff;
    }

    private function getLowestNote($notes)
    {
        $i = 1;
        $cnt = count($notes);
        $res = 0;
        foreach($notes as $nom => $qnt){
            if($i != $cnt && $qnt != 0){
                $res = $nom;
            }
            $i++;
        }
        return $res;
    }

    private function deriveOneNote($draw, $note)
    {
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

    private function getSumm($notes)
    {
        $summ = 0;
        foreach($notes as $nom => $qnt){
            $summ += $nom * $qnt;
        }
        return $summ;
    }

    private function recordStep($step)
    {
        $this->steps[] = $step;
    }

}


