<?php

namespace App\View\Components\Zahlungen;

use Illuminate\View\Component;

class Edit extends Component
{
    public $zahlung;
    public $zahlungsarten;

    public function __construct($zahlung, $zahlungsarten)
    {
        $this->zahlung = $zahlung;
        $this->zahlungsarten = $zahlungsarten;
    }

    public function render()
    {
        return view('components.zahlungen.edit');
    }
}
