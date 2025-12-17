<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

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
        return [
            Column::make(view('admin.categories.checkbox-header')->render())
                ->label(fn($row) => view('admin.categories.checkbox', ['row' => $row]))
                ->html()
                ->excludeFromColumnSelect(),
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

        $this->selected = array_values(array_diff($this->getSelected(), [$id]));
        $this->dispatchSelectionCount();

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

}
