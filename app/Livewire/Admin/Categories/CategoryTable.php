<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\CheckboxColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\TextColumn;

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
            TextColumn::make('ID', 'id')->sortable()->searchable(),
            TextColumn::make('Nombre', 'name')->sortable()->searchable(),
            TextColumn::make('Familia', 'family.name')->sortable()->searchable(),
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
        $selectedIds = $this->getSelected();

        if (empty($selectedIds)) {
            return;
        }

        Category::whereIn('id', $selectedIds)->delete();

        $this->clearSelected();

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
