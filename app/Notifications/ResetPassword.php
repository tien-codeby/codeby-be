<?php

namespace App\Notifications;

use App\Mail\ResetPassword as ResetPasswordMailable;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    use Queueable;


    private $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return Mailable
     */
    public function toMail($notifiable)
    {
        $user = $notifiable->toArray();
        $reset_url = join('', [
            config('app.frontend_url'),
            '/ResetPasswordPage?',
            http_build_query(['email' => $user['email'], 'token' => $this->token])
        ]);
        $code = Carbon::parse($user['updated_at'])->format('His');
        $data = [
            'user'      => $user,
            'reset_url' => $reset_url,
            'code'      => $code,
        ];
        return (new ResetPasswordMailable($data))
            ->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
