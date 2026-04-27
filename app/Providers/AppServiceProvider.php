<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use App\Models\SystemNotification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Laravel 11 Event Listener
        Event::listen(Login::class, function (Login $event) {
            
            // 1. Save last login time
            $event->user->last_login_at = now();
            $event->user->save();

            // 2. Create notification ONLY if they are a student
            if ($event->user->role !== 'admin') {
                SystemNotification::create([
                    'type' => 'login',
                    'message' => "<strong>{$event->user->username}</strong> just logged into the portal."
                ]);
            }
        });
    }
}