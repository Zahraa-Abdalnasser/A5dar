<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order; 
class NewOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('New Order on Your Offer')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A trader has placed an order on your offer: ' . $this->order->offer->title . '.')
            ->line('Order Amount: ' . $this->order->amount)
            ->action('View Order', url('/orders/' . $this->order->id))
            ->line('Thank you for using our platform!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */


     
    /********** 
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'A new order has been placed on your offer.',
            'order_id' => $this->order->id,
            'url' => url('/orders/' . $this->order->id),
        ];
    }
        ***********/
}
