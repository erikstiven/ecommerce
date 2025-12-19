<?php

namespace App\Livewire\Admin\Subcategories;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SubcategoryTable extends DataTableComponent
{
    protected $model = Subcategory::class;

    protected $listeners = ['deleteSubcategory'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTheme('tailwind');
        $this->setColumnSelectEnabled();
    }

    public function builder(): Builder
    {
        return Subcategory::query()
            ->select('subcategories.*', 'categories.name as category_name', 'families.name as family_name')
            ->join('categories', 'categories.id', '=', 'subcategories.category_id')
            ->join('families', 'families.id', '=', 'categories.family_id');
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
            Column::make('Categoría')
                ->label(fn(Subcategory $row) => $row->category_name ?? '-')
                ->sortable(function (Builder $query, string $direction) {
                    $query->orderBy('category_name', $direction);
                })
                ->searchable(function (Builder $query, string $term) {
                    $query->where('categories.name', 'like', "%{$term}%");
                }),
            Column::make('Familia')
                ->label(fn(Subcategory $row) => $row->family_name ?? '-')
                ->sortable(function (Builder $query, string $direction) {
                    $query->orderBy('family_name', $direction);
                })
                ->searchable(function (Builder $query, string $term) {
                    $query->where('families.name', 'like', "%{$term}%");
                }),
            Column::make('Acciones')
                ->label(fn($row) => view('admin.subcategories.actions', ['subcategory' => $row]))
                ->html(),
        ];
    }

    public function deleteSubcategory($id): void
    {
        $subcategory = Subcategory::findOrFail($id);

        if ($subcategory->products()->exists()) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => 'No se puede eliminar',
                'text'  => 'La subcategoría tiene productos asociados.',
            ]);

            return;
        }

        $subcategory->delete();

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Subcategoría eliminada',
            'text'  => 'La subcategoría se eliminó correctamente.',
        ]);
    }

    public function deleteSelected(): void
    {
        if (! $this->hasBulkSelection()) {
            return;
        }

        $this->js(<<<'JS'
            if (confirm('¿Eliminar las subcategorías seleccionadas? Esta acción no se puede deshacer.')) {
                $wire.call('performBulkDeletion');
            }
        JS);
    }

    public function performBulkDeletion(): void
    {
        if (! $this->hasBulkSelection()) {
            return;
        }

        $subcategories = Subcategory::withCount('products')->whereIn('id', $this->selected)->get();

        $blocked = $subcategories->filter(fn($subcategory) => $subcategory->products_count > 0);
        $deletable = $subcategories->where('products_count', 0);

        foreach ($deletable as $subcategory) {
            $subcategory->delete();
        }

        $this->clearBulkSelection();

        if ($blocked->isNotEmpty()) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => 'Algunas subcategorías no se pudieron eliminar',
                'text'  => 'Hay subcategorías con productos asociados.',
            ]);

            return;
        }

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Subcategorías eliminadas',
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
