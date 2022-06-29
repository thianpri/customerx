<?php

namespace thianpri\FilamentSertifikat\Traits;

trait HasContentEditor
{
    public static function getContentEditor(string $field)
    {
        $defaultEditor = config('filament-sertifikat.editor');

        return $defaultEditor::make($field)
            ->required()
            ->toolbarButtons(config('filament-sertifikat.toolbar_buttons'))
            ->columnSpan([
                'sm' => 2,
            ]);
    }
}
