<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Tenant; // Import the Tenant model

class TrialExpiryAlert extends Notification
{
    use Queueable;

    protected $tenant;
    protected $days;

    public function __construct(Tenant $tenant, int $days)
    {
        $this->tenant = $tenant;
        $this->days = $days;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $actionUrl = config('app.url') . '/admin';

        return (new MailMessage)
                    ->subject("Cip-Tools: Trial Account Expiry Alert ({$this->days} Days Left)")
                    ->greeting("Hello {$notifiable->name},")
                    ->line("Your project, **{$this->tenant->id}.cip-tools.de**, has only **{$this->days} days** remaining on its free trial period.")
                    ->line('Please ensure payment is made before the trial ends to avoid service interruption.')
                    ->action('Go to Billing Portal', $actionUrl)
                    ->line('Thank you for using our application!');
    }
}