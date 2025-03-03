<?php

namespace Koverae\KoveraeBilling\Providers;

use Illuminate\Support\ServiceProvider;
use Koverae\KoveraeBilling\KoveraeBilling;

class KoveraeBillingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishConfig();
        $this->publishMigrations();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'koverae-billing');

        // Register the main class to use with the facade
        $this->app->singleton('koverae-billing', function () {
            return new KoveraeBilling;
        });
    }

    /**
     * Publish package config.
     *
     * @return void
     */
    protected function publishConfig(){
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('koverae-billing.php'),
        ], 'koverae-billing.config');
    }


    /**
     * Publish package migrations.
     *
     * @return void
     */
    protected function publishMigrations()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/create_plans_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_plans_table.php'),
            __DIR__ . '/../database/migrations/create_plan_features_table.php' => database_path('migrations/' . date('Y_m_d_His', time() + 1) . '_create_plan_features_table.php'),
            __DIR__ . '/../database/migrations/create_plan_subscriptions_table.php' => database_path('migrations/' . date('Y_m_d_His', time() + 2) . '_create_plan_subscriptions_table.php'),
            __DIR__ . '/../database/migrations/create_plan_subscription_features_table.php' => database_path('migrations/' . date('Y_m_d_His', time() + 3) . '_create_plan_subscription_features_table.php'),
            __DIR__ . '/../database/migrations/create_plan_subscription_usage_table.php' => database_path('migrations/' . date('Y_m_d_His', time() + 4) . '_create_plan_subscription_usage_table.php'),
            __DIR__ . '/../database/migrations/create_plan_subscription_schedules_table.php' => database_path('migrations/' . date('Y_m_d_His', time() + 5) . '_create_plan_subscription_schedules_table.php'),
            __DIR__ . '/../database/migrations/create_plan_combinations_table.php' => database_path('migrations/' . date('Y_m_d_His', time() + 6) . '_create_plan_combinations_table.php'),
            __DIR__ . '/../database/migrations/create_transactions_table.php' => database_path('migrations/' . date('Y_m_d_His', time() + 6) . '_create_transactions_table.php')
        ], 'koverae-billing.migrations');

    }

}
