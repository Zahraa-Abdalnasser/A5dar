<?php

namespace App\Listeners;

use App\Events\OrderResponse;
use App\Notifications\OrderStatusNotification; 
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderResponseNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderResponse $event): void
    {
    
        // Notify the trader that their order was accepted or rejected
        $event->order->user->notify(new OrderStatusNotification($event->order));
    
    }
}
