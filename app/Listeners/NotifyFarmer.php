<?php

namespace App\Listeners;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyFarmer
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
    public function handle(OrderPlaced $event): void
    {
        $farmer = User::find($event->offer->user_id);
        if ($farmer) {
            $farmer->notify(new NewOrderNotification($event->order));
        }
    }
}
