<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendTwoFactorCode extends Notification
{
    use Queueable;
    public $code;

    /**
     * Create a new notification instance.
     */
    public function __construct($code)
    {
        $this->code = $code;
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('two_factor.title_setup')) // Uses your localization title
            ->greeting(__('home.hello') . ' ' . $notifiable->name . '!')
            ->line(__('two_factor.desc_setup'))

            ->with([
                'level' => 'success',
            ])
            ->line(' ')
            ->line('👉 **' . $this->code . '** 👈')
            ->line(' ')

            ->line(__('two_factor.desc_setup_check'))
            ->salutation(__('home.regards') . ",\n" . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
