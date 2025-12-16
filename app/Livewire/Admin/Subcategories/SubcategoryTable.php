<?php

namespace App\Livewire\Admin\Subcategories;

use App\Livewire\Admin\Tables\BaseAdminTable;
use App\Models\Subcategory;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SubcategoryTable extends BaseAdminTable
{
    protected $model = Subcategory::class;

    protected $listeners = ['deleteSubcategory', 'deleteSelected'];

    public function configure(): void
    {
        parent::configure();
        $this->setAdditionalSelects(['subcategories.id as id']);
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable()->searchable(),
            Column::make('Nombre', 'name')->sortable()->searchable(),
            Column::make('Familia', 'family.name')->sortable()->searchable(),
            Column::make('Categoría', 'category.name')->sortable()->searchable(),
            Column::make('Acciones')
                ->label(fn($row) => view('admin.subcategories.actions', ['subcategory' => $row]))
                ->html(),
        ];
    }

    public function bulkActions(): array
    {
        return [
            'deleteSelected' => 'Eliminar seleccionados',
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
}
