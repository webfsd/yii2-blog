<?php
namespace common\widgets;

use yii\bootstrap\Widget;

class Label extends Widget
{
    public $name;
    public $frequency;

    public $labelTypes = [
        5 => 'danger',
        4 => 'warning',
        3 => 'info',
        2 => 'success',
        1 => 'primary',
        0 => 'default'
    ];

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $size = $this->frequency%6;
        $lableType = $this->labelTypes[$size];

        return sprintf('<span class="label label-%s">%s</span>',$lableType,$this->name);
    }


}