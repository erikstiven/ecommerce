<?php

namespace App\Livewire\Admin\Subcategories;

use App\Models\Subcategory;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\CheckboxColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\Column;

class SubcategoryTable extends DataTableComponent
{
    protected $model = Subcategory::class;

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
            CheckboxColumn::make(),
            Column::make('ID', 'id')->sortable()->searchable(),
            Column::make('Nombre', 'name')->sortable()->searchable(),
            Column::make('Familia', 'family.name')->sortable()->searchable(),
            Column::make('Categoría', 'category.name')->sortable()->searchable(),
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
        $selectedIds = collect($this->selected ?? [])->filter()->all();

        if (empty($selectedIds)) {
            return;
        }

        Subcategory::whereIn('id', $selectedIds)->delete();

        $this->clearSelection();

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

    protected function clearSelection(): void
    {
        $this->selected = [];
        $this->dispatchSelectionCount();
    }

    protected function pruneSelection(array $ids): void
    {
        if (!isset($this->selected)) {
            return;
        }

        $this->selected = array_values(array_diff($this->selected, $ids));
        $this->dispatchSelectionCount();
    }
}
