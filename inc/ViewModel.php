<?php
namespace ATM;

class ViewModel
{
    public $btn_colors = array('default', 'primary', 'success', 'info', 'warning', 'danger');
    public $steps = array();
    public $error = '';

    public function __construct($ATM)
    {
        $this->banknotes = $ATM->notes;
    }

    public function get_banknotes()
    {
        $buttons = "<div class='btn-toolbar'>";
        foreach($this->banknotes as $nominal => $quantity){
            $key = array_search($nominal, array_keys($this->banknotes));
            $buttons .= "<div class='btn-group'>";
                $buttons .= "<button type='button' class='btn btn-sm btn-".$this->btn_colors[$key]."'>
                             $nominal<span class='badge'>$quantity</span></button>";
            $buttons .= "</div>";
        }
        $buttons .= "</div>";
        return $buttons;
    }

    public function display_steps($steps)
    {
        if(!$steps){
            $this->error = 'error';
            return;
        }

        $btn_colors = array('default', 'primary', 'success', 'info', 'warning', 'danger');
        $html = '';

        foreach ($steps as $step){
            $html .= '<div class="buttons_block">';
            foreach($step as $nom => $qnt){
                if($qnt == 0)
                    continue;
                for($q = 0; $q < $qnt; $q++){
                    $color_key = array_search($nom, array_keys($this->banknotes));
                    $html .= "<button type='button' class='btn btn-xs btn-".$btn_colors[$color_key]."'>
                                 $nom<span class='badge'>1</span></button>";
                }
            }
            $html .= '</div>';
        }

        return $html;
    }
}