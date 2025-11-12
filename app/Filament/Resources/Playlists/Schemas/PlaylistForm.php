<?php

namespace App\Filament\Resources\Playlists\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\RichEditor;

class PlaylistForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('band')
                    ->label('Band Name')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('link_youtube')
                    ->label('Embed Youtube'),
                CodeEditor::make('content')
                    ->label('Chord & Lirik')
                    ->required()
                    ->columnSpanFull(),
                RichEditor::make('content_additional')
                    ->label('Konten Tambahan')
                    ->columnSpanFull(),
                DateTimePicker::make('published_at')
                    ->label('Add Published Date')
                    ->native(false) // gunakan flatpickr, bukan native input
                    ->displayFormat('Y-m-d') // format tampilan
                    ->closeOnDateSelection(true)
                    ->required(),
            ]);
    }
}
