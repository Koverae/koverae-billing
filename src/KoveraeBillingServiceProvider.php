<?php

namespace Koverae\KoveraeBilling;

use Illuminate\Support\ServiceProvider;
use Koverae\KoveraeBilling\KoveraeBilling;
use Koverae\KoveraeBilling\Console\InstallCommand;
use Koverae\KoveraeBilling\Console\SendSubscriptionRemindersCommand;
use Illuminate\Support\Facades\Blade;
use App\Models\Team\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class KoveraeBillingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishConfig();
        $this->publishMigrations();

        $this->commands([
            InstallCommand::class,
            SendSubscriptionRemindersCommand::class,
        ]);

        Blade::if('subscribeFeature', function ($featureTag) {

            $user = User::find(Auth::user()->id);
            $team = Team::find($user->company->team_id);

            if (!$team) {
                abort(403, 'No team found.');
            }
            // Result you got "@subscribeFeature "@endsubscribeFeature

            return $team && $team->subscribedFeature($featureTag);
        });
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
        $timestamp = now()->format('Y_m_d_His');

        $migrations = [
            'create_plans_table.php',
            'create_plan_features_table.php',
            'create_plan_subscriptions_table.php',
            'create_plan_subscription_features_table.php',
            'create_plan_subscription_usage_table.php',
            'create_plan_subscription_schedules_table.php',
            'create_plan_combinations_table.php',
            'create_transactions_table.php',
        ];

        $migrationFiles = [];

        foreach ($migrations as $index => $migration) {
            $migrationFiles[__DIR__ . "/../database/migrations/{$migration}"] =
                database_path("migrations/{$timestamp}_{$migration}");

            // Increment timestamp safely
            $timestamp = now()->addSeconds(1)->format('Y_m_d_His');
        }

        $this->publishes($migrationFiles, 'koverae-billing.migrations');
    }


}
