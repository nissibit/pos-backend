<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{

    public $color;
    public $icon;
    public $message;
    public $type;
    /**
     * Create a new component instance.
     */
    public function __construct(String $type, String $message)
    {
        if ($type === 'sucesso') {
            $this->color = 'green';
            $this->icon = 'check-circle';
        } elseif ($type === 'falha') {
            $this->color = 'red';
            $this->icon = 'triangle-exclamation';
        } elseif ($type === 'alert') {
            $this->color = 'yellow';
            $this->icon = 'triangle-exclamation';
        } else {
            $this->color = 'blue';
            $this->icon = 'info-circle';
        }
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}
