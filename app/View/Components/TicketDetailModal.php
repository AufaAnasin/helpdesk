<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TicketDetailModal extends Component
{
    /**
     * Create a new component instance.
     */
    public $ticket;

    public function __construct($ticket)
    {
        //
        $this->ticket = $ticket;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ticket-detail-modal');
    }
}
