<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use App\Models\Family;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CategoryTable extends DataTableComponent
{
    protected $model = Category::class;

    protected $listeners = ['deleteCategory'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTheme('tailwind');
    }

    public function builder(): Builder
    {
        return Category::query()->with('family');
    }

    public function bulkActions(): array
    {
        return [
            'deleteSelected' => 'Eliminar seleccionados',
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable()->searchable(),
            Column::make('Nombre', 'name')->sortable()->searchable(),
            Column::make('Familia')
                ->label(fn($row) => $row->family?->name ?? '-')
                ->sortable(function (Builder $query, string $direction) {
                    $query->orderBy(
                        Family::select('name')
                            ->whereColumn('families.id', 'categories.family_id'),
                        $direction
                    );
                })
                ->searchable(function (Builder $query, string $term) {
                    $query->whereHas('family', fn(Builder $familyQuery) =>
                        $familyQuery->where('name', 'like', "%{$term}%")
                    );
                }),
            Column::make('Acciones')
                ->label(fn($row) => view('admin.categories.actions', ['category' => $row]))
                ->html(),
        ];
    }

    public function deleteCategory($id): void
    {
        $category = Category::findOrFail($id);

        if ($category->subcategories()->exists()) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => 'No se puede eliminar',
                'text'  => 'La categoría tiene subcategorías asociadas.',
            ]);

            return;
        }

        $category->delete();

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Categoría eliminada',
            'text'  => 'La categoría se eliminó correctamente.',
        ]);
    }

    public function deleteSelected(): void
    {
        if (! $this->hasBulkSelection()) {
            return;
        }

        $this->js(<<<'JS'
            if (confirm('¿Eliminar las categorías seleccionadas? Esta acción no se puede deshacer.')) {
                $wire.call('performBulkDeletion');
            }
        JS);
    }

    public function performBulkDeletion(): void
    {
        if (! $this->hasBulkSelection()) {
            return;
        }

        $categories = Category::withCount('subcategories')->whereIn('id', $this->selected)->get();

        $blocked = $categories->filter(fn($category) => $category->subcategories_count > 0);
        $deletable = $categories->where('subcategories_count', 0);

        foreach ($deletable as $category) {
            $category->delete();
        }

        $this->clearBulkSelection();

        if ($blocked->isNotEmpty()) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => 'Algunas categorías no se pudieron eliminar',
                'text'  => 'Hay categorías con subcategorías asociadas.',
            ]);

            return;
        }

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Categorías eliminadas',
            'text'  => 'Los elementos seleccionados se eliminaron correctamente.',
        ]);
    }

    protected function hasBulkSelection(): bool
    {
        return isset($this->selected) && count($this->selected) > 0;
    }

    protected function clearBulkSelection(): void
    {
        if (method_exists($this, 'clearSelected')) {
            $this->clearSelected();
            return;
        }

        $this->selected = [];
    }
}
