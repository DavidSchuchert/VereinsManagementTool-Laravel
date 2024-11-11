<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MitgliederSuchFilterForm extends Component
{
    public $rangarten;
    public $meldung;


    /**
     * Create a new component instance.
     */
    public function __construct($rangarten)
    {
        $this->rangarten = $rangarten;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.mitglieder-such-filter-form');
    }
}
