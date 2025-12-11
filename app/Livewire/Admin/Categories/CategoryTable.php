<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\CheckboxColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\Column;

class CategoryTable extends DataTableComponent
{
    protected $model = Category::class;

    public array $selected = [];

    protected $listeners = ['deleteCategory', 'deleteSelected'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTheme('tailwind');
        $this->setAdditionalSelects(['categories.id as id']);
    }

    public function updatedSelected(): void
    {
        $this->dispatchSelectionCount();
    }

    public function columns(): array
    {
        return [
            CheckboxColumn::make('Seleccionar'),
            Column::make('ID', 'id')->sortable()->searchable(),
            Column::make('Nombre', 'name')->sortable()->searchable(),
            Column::make('Familia', 'family.name')->sortable()->searchable(),
            Column::make('Acciones')
                ->label(fn($row) => view('admin.categories.actions', ['category' => $row]))
                ->html(),
        ];
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        $this->pruneSelection([$id]);

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Categoría eliminada',
            'text'  => 'La categoría se eliminó correctamente.',
        ]);
    }

    public function deleteSelected(): void
    {
        $selectedIds = collect($this->selected ?? [])->filter()->all();

        if (empty($selectedIds)) {
            return;
        }

        Category::whereIn('id', $selectedIds)->delete();

        $this->clearSelection();

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Categorías eliminadas',
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
