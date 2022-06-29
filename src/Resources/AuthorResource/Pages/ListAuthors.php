<?php

namespace thianpri\FilamentLab\Resources\AuthorResource\Pages;

use Filament\Resources\Pages\ListRecords;
use thianpri\FilamentLab\Resources\AuthorResource;

class ListAuthors extends ListRecords
{
    protected static string $resource = AuthorResource::class;
}
