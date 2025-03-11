<?php

declare(strict_types=1);

namespace Koverae\KoveraeBilling\Services\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Koverae Billing resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // $this->comment('Publishing Koverae Billing Assets...');
        // $this->callSilent('vendor:publish', ['--tag' => 'koverae-billing.assets']);

        $this->comment('Publishing Koverae Billing Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'koverae-billing.config']);

        $this->comment('Publishing Koverae Billing Migrations...');
        $this->callSilent('vendor:publish', ['--tag' => 'koverae-billing.migrations']);

        $this->info('Koverae Billing was installed successfully.');

        $this->info("--------------------------------------------------");
        $this->info("✅ Koverae Billing is ready for use! 🚀");
        $this->info("--------------------------------------------------");
    }
}

