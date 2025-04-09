<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class SidebarItem extends Component
{
    /**
     * Create a new component instance.
     */
    public $route;
    public $role;
    public $item_name;
    public $icon;
    
    public function __construct($role='', $route='', $item_name='', $icon='')
    {

        $this->route = $route;
        $this->role = $role;
        $this->item_name = $item_name;
        $this->icon = $icon;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar-item');
    }
}
