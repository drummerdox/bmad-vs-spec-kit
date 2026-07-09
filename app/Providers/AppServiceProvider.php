<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('layouts.guest', function ($view) {
            $pages = [
                'login' => [
                    'title' => 'Log in',
                    'description' => 'Sign in to your Todo App account and pick up right where you left off.',
                ],
                'register' => [
                    'title' => 'Create account',
                    'description' => 'Register for free and start organizing your tasks with priorities and filters.',
                ],
                'password.request' => [
                    'title' => 'Reset password',
                    'description' => 'Request a password reset link for your Todo App account.',
                ],
                'password.reset' => [
                    'title' => 'Choose new password',
                    'description' => 'Set a new password for your Todo App account.',
                ],
            ];

            foreach ($pages as $route => $meta) {
                if (request()->routeIs($route)) {
                    $view->with([
                        'seoTitle' => $meta['title'],
                        'seoDescription' => $meta['description'],
                    ]);

                    return;
                }
            }
        });
    }
}
