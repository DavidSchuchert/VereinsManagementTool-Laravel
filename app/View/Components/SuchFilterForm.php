<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SuchFilterForm extends Component
{
    public $zahlungsarten;
    public $meldung;


    /**
     * Create a new component instance.
     */
    public function __construct($zahlungsarten, $meldung)
    {
        $this->zahlungsarten = $zahlungsarten;
        $this->meldung = $meldung;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.such-filter-form');
    }
}
