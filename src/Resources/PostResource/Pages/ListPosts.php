<?php

namespace thianpri\FilamentLab\Resources\PostResource\Pages;

use Filament\Resources\Pages\ListRecords;
use thianpri\FilamentLab\Resources\PostResource;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;
}
