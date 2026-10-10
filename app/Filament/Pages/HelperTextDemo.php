<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Page;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;

class HelperTextDemo extends Page
{
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Works: the input gets aria-describedby (and aria-invalid on error).
                TextInput::make('name')
                    ->required()
                    ->helperText('Text input helper text.'),

                // Bug: the switch button gets neither, though the helper text has an id.
                Toggle::make('terms')
                    ->accepted()
                    ->helperText('Toggle helper text.'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $this->form->getState();
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([EmbeddedSchema::make('form')])
                ->livewireSubmitHandler('save')
                ->footer([
                    \Filament\Schemas\Components\Actions::make([
                        \Filament\Actions\Action::make('save')->submit('save'),
                    ]),
                ]),
        ]);
    }
}
