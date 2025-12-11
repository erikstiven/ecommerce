<?php

namespace App\Livewire\Admin\Families;

use App\Models\Family;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\TextColumn;

class FamilyTable extends DataTableComponent
{

    protected $model = Family::class;

    public array $selected = [];

    protected $listeners = ['deleteFamily', 'deleteSelected'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTheme('tailwind');

        $this->setConfigurableAreas([
            'toolbar-left-start' => 'admin.categories.toolbar',
        ]);
    }

    public function updatedSelected(): void
    {
        $this->dispatchSelectionCount();
    }

    public function columns(): array
    {
        $headerCheckbox = view('admin.categories.checkbox-header')->render();

        return [
            Column::make($headerCheckbox)
                ->label(fn($row) => view('admin.categories.checkbox', ['row' => $row]))
                ->html()
                ->excludeFromColumnSelect(),
            TextColumn::make('ID', 'id')->sortable()->searchable(),
            TextColumn::make('Nombre', 'name')->sortable()->searchable(),
            Column::make('Acciones')
                ->label(fn($row) => view('admin.families.actions', ['family' => $row]))
                ->html(),
        ];
    }

    public function deleteFamily($id)
    {
        $family = Family::findOrFail($id);
        $family->delete();

        $this->selected = array_values(array_diff($this->getSelected(), [$id]));
        $this->dispatchSelectionCount();

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Familia eliminada',
            'text'  => 'La familia se eliminó correctamente.',
        ]);
    }

    public function deleteSelected(): void
    {
        $selectedIds = $this->getSelected();

        if (empty($selectedIds)) {
            return;
        }

        Family::whereIn('id', $selectedIds)->delete();

        $this->clearSelected();

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Familias eliminadas',
            'text'  => 'Los elementos seleccionados se eliminaron correctamente.',
        ]);
    }

    protected function dispatchSelectionCount(): void
    {
        $this->dispatch('selection-updated', count: count($this->selected ?? []));
    }

    public function getSelected(): array
    {
        return array_values(collect($this->selected ?? [])->filter()->all());
    }

    public function clearSelected(): void
    {
        $this->selected = [];
        $this->dispatchSelectionCount();
    }

}
