<?php

namespace thianpri\FilamentLab;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;
use thianpri\FilamentLab\Commands\InstallCommand;
use thianpri\FilamentLab\Resources\AuthorResource;
use thianpri\FilamentLab\Resources\CategoryResource;
use thianpri\FilamentLab\Resources\PostResource;

class LabServiceProvider extends PluginServiceProvider
{
    protected array $resources = [
        AuthorResource::class,
        CategoryResource::class,
        PostResource::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-lab')
            ->hasConfigFile()
            ->hasCommand(InstallCommand::class)
            ->hasMigration('create_filament_lab_tables');
    }
}
