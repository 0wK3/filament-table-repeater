<?php

namespace Awcodes\FilamentTableRepeater\Tests\Fixtures;

use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Illuminate\View\View;
use Livewire\Component;

class Livewire extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public static function make(): static
    {
        return new static();
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function data($data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $model = app($this->form->getModel());

        $model->update($data);
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $model = app($this->form->getModel());

        $model->create($data);
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->statePath('data')
            ->model(Page::class)
            ->schema(static::getFullFormSchema());
    }

    public function render(): View
    {
        return view('fixtures.form');
    }

    public static function getFullFormSchema(): array
    {
        return [
            TableRepeater::make('table_repeater')
                ->schema(static::getRepeaterFormSchema()),
        ];
    }

    public static function getRepeaterFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name'),
        ];
    }
}
