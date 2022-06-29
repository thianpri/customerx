<?php

namespace thianpri\FilamentLab\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filament-lab:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the lab resources';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->comment('Publishing Lab Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'filament-lab-config']);

        $this->comment('Publishing Filament Lab Migrations...');
        $this->callSilent('vendor:publish', ['--tag' => 'filament-lab-migrations']);
        $this->callSilent('vendor:publish', ['--tag' => 'tags-migrations']);

        $this->info('Filament lab was installed successfully.');

        return 0;
    }
}
