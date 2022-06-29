<?php

namespace thianpri\FilamentLab\Traits;

trait HasContentEditor
{
    public static function getContentEditor(string $field)
    {
        $defaultEditor = config('filament-lab.editor');

        return $defaultEditor::make($field)
            ->required()
            ->toolbarButtons(config('filament-lab.toolbar_buttons'))
            ->columnSpan([
                'sm' => 2,
            ]);
    }
}
