<?php

namespace App\Livewire\Admin\Subcategories;

use App\Models\Subcategory;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\CheckboxColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\TextColumn;

class SubcategoryTable extends DataTableComponent
{

    protected $model = Subcategory::class;

    public array $selected = [];

    protected $listeners = ['deleteSubcategory', 'deleteSelected'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTheme('tailwind');
        $this->setAdditionalSelects(['subcategories.id as id']);
    }

    public function updatedSelected(): void
    {
        $this->dispatchSelectionCount();
    }

    public function columns(): array
    {
        return [
            CheckboxColumn::make('Seleccionar'),
            TextColumn::make('ID', 'id')->sortable()->searchable(),
            TextColumn::make('Nombre', 'name')->sortable()->searchable(),
            TextColumn::make('Familia', 'family.name')->sortable()->searchable(),
            TextColumn::make('Categoría', 'category.name')->sortable()->searchable(),
            Column::make('Acciones')
                ->label(fn($row) => view('admin.subcategories.actions', ['subcategory' => $row]))
                ->html(),
        ];
    }

    public function deleteSubcategory($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->delete();

        $this->pruneSelection([$id]);

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Subcategoría eliminada',
            'text'  => 'La subcategoría se eliminó correctamente.',
        ]);
    }

    public function deleteSelected(): void
    {
        $selectedIds = $this->getSelected();

        if (empty($selectedIds)) {
            return;
        }

        Subcategory::whereIn('id', $selectedIds)->delete();

        $this->clearSelected();

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Subcategorías eliminadas',
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

    protected function pruneSelection(array $ids): void
    {
        $this->selected = array_values(array_diff($this->getSelected(), $ids));
        $this->dispatchSelectionCount();
    }
}
