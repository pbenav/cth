<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../vendor/laravel/jetstream/stubs/livewire/resources/views', 'jetstream');

        Blade::component('jetstream::components.action-message', 'jet-action-message');
        Blade::component('jetstream::components.action-section', 'jet-action-section');
        Blade::component('jetstream::components.authentication-card', 'jet-authentication-card');
        Blade::component('jetstream::components.authentication-card-logo', 'jet-authentication-card-logo');
        Blade::component('jetstream::components.banner', 'jet-banner');
        Blade::component('jetstream::components.button', 'jet-button');
        Blade::component('jetstream::components.checkbox', 'jet-checkbox');
        Blade::component('jetstream::components.confirmation-modal', 'jet-confirmation-modal');
        Blade::component('jetstream::components.confirms-password', 'jet-confirms-password');
        Blade::component('jetstream::components.danger-button', 'jet-danger-button');
        Blade::component('jetstream::components.dialog-modal', 'jet-dialog-modal');
        Blade::component('jetstream::components.dropdown', 'jet-dropdown');
        Blade::component('jetstream::components.dropdown-link', 'jet-dropdown-link');
        Blade::component('jetstream::components.form-section', 'jet-form-section');
        Blade::component('jetstream::components.input', 'jet-input');
        Blade::component('jetstream::components.input-error', 'jet-input-error');
        Blade::component('jetstream::components.label', 'jet-label');
        Blade::component('jetstream::components.modal', 'jet-modal');
        Blade::component('jetstream::components.nav-link', 'jet-nav-link');
        Blade::component('jetstream::components.responsive-nav-link', 'jet-responsive-nav-link');
        Blade::component('jetstream::components.secondary-button', 'jet-secondary-button');
        Blade::component('jetstream::components.section-border', 'jet-section-border');
        Blade::component('jetstream::components.section-title', 'jet-section-title');
        Blade::component('jetstream::components.switchable-team', 'jet-switchable-team');
        Blade::component('jetstream::components.welcome', 'jet-welcome');
        Blade::component('jetstream::components.validation-errors', 'jet-validation-errors');
    }
}
