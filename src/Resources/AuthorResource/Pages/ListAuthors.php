<?php

namespace thianpri\FilamentSertifikat\Resources\CustomerResource\Pages;

use Filament\Resources\Pages\ListRecords;
use thianpri\FilamentSertifikat\Resources\CustomerResource;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;
}
