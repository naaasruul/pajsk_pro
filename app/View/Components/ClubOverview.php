<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ClubOverview extends Component
{
    /**
     * Create a new component instance.
     */
    public $clubName;
    public $clubCategory;
    public function __construct($clubCategory='', $clubName='')
    {
        $this->clubCategory = $clubCategory;
        $this->clubName = $clubName;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.club-overview');
    }
}
