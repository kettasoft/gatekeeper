<?php

namespace Kettasoft\Gatekeeper\Commands;

use Illuminate\Console\Command;

class RunMigraitonsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gatekeeper:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run gatekeeper migrations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('migrate', [
            '--path' => 'vendor/kettasoft/gatekeeper/database/migrations'
        ]);
    }
}
