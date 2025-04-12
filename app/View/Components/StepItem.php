<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StepItem extends Component
{
    public $step;
    public $label;
    public $active;

    /**
     * Create a new component instance.
     *
     * @param int $step
     * @param string $label
     * @param bool $active
     */
    public function __construct($step, $label, $active = false)
    {
        $this->step = $step;
        $this->label = $label;
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.step-item');
    }
}