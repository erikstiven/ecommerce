<?php

namespace App\Livewire\Admin\Concerns;

use Rappasoft\LaravelLivewireTables\Views\Columns\CheckboxColumn;

trait ProvidesCheckboxColumn
{
    protected function selectionColumn(): CheckboxColumn
    {
        return CheckboxColumn::make(__('Seleccionar'));
    }
}
