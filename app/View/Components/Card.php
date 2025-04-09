<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Card extends Component
{
    public $title;
    public $user;
    /**
     * Create a new component instance.
     */
    public function __construct($title='',$user='' )
    {
        $this->title = $title;
        $this->user = $user;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        return view('components.card');
    }
}
