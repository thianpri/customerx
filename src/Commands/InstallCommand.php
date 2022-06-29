<?php

namespace thianpri\FilamentSertifikat\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filament-sertifikat:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the sertifikat resources';

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
        $this->comment('Publishing Sertifikat Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'filament-sertifikat-config']);

        $this->comment('Publishing Filament Sertifikat Migrations...');
        $this->callSilent('vendor:publish', ['--tag' => 'filament-sertifikat-migrations']);
        $this->callSilent('vendor:publish', ['--tag' => 'tags-migrations']);

        $this->info('Filament sertifikat was installed successfully.');

        return 0;
    }
}
