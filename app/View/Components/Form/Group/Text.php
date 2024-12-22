<?php

namespace App\View\Components\Form\Group;

use Illuminate\View\Component;

class Text extends Component
{
    public $name;
    public $label;
    public $placeholder;
    public $formGroupClass;
    public $inputGroupClass;

    public function __construct($name, $label, $placeholder, $formGroupClass = '', $inputGroupClass = '')
    {
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->formGroupClass = $formGroupClass;
        $this->inputGroupClass = $inputGroupClass;
    }

    public function render()
    {
        return view('components.form.group.text');
    }
}