<?php

namespace thianpri\FilamentSertifikat;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use thianpri\FilamentSertifikat\Commands\InstallCommand;
use thianpri\FilamentSertifikat\Resources\CustomerResource;
use thianpri\FilamentSertifikat\Resources\CategoryResource;
use thianpri\FilamentSertifikat\Resources\JawabanResource;

class SertifikatServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        CustomerResource::class,
        CategoryResource::class,
        JawabanResource::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-sertifikatx')
            ->hasConfigFile()
            ->hasCommand(InstallCommand::class)
            ->hasMigration('create_filament_sertifikat_tablesx');
    }
}
