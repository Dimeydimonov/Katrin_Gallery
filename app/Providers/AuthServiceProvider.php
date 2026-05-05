<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\URL;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Like::class    => \App\Policies\LikePolicy::class,
        \App\Models\Artwork::class => \App\Policies\ArtworkPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        \Illuminate\Auth\Notifications\VerifyEmail::toMailUsing(function ($notifiable) {
            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(config('auth.verification.expire', 60)),
                [
                    'id'   => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );

            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Підтвердження адреси електронної пошти')
                ->line('Будь ласка, натисніть кнопку нижче, щоб підтвердити вашу адресу електронної пошти.')
                ->action('Підтвердити Email', $verifyUrl)
                ->line('Якщо ви не створювали обліковий запис, жодних подальших дій не потрібно.');
        });
    }
}
