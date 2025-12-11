<?php

namespace App\Livewire\Admin\Drivers;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use App\Models\Driver;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\TextColumn;

class DriverTable extends DataTableComponent
{
    protected $model = Driver::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTheme('tailwind');
    }

    public function columns(): array
    {
        return [
            TextColumn::make("Id", "id")
                ->sortable(),
            TextColumn::make("Type", "type")
                ->format(function ($value) {
                    $type = match ($value) {
                        1 => 'Moto',
                        2 => 'Auto',
                        default => 'Desconocido',
                    };
                    return $type;
                })
                ->sortable(),

            // Column::make("Type", "type")
            //     ->sortable(),
            TextColumn::make("Nombre", "user.name")
                ->sortable(),
            
                LinkColumn::make('Action')
                ->title(fn ($row) => 'Edit')
                ->location(fn ($row) => route('admin.drivers.edit', $row))


        ];
    }
}
