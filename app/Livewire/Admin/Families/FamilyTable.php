<?php

namespace App\Livewire\Admin\Families;

use App\Livewire\Admin\Tables\BaseAdminTable;
use App\Models\Family;
use Rappasoft\LaravelLivewireTables\Views\Column;

class FamilyTable extends BaseAdminTable
{
    protected $model = Family::class;

    protected $listeners = ['deleteFamily', 'deleteSelected'];

    public function configure(): void
    {
        parent::configure();
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable()->searchable(),
            Column::make('Nombre', 'name')->sortable()->searchable(),
            Column::make('Acciones')
                ->label(fn($row) => view('admin.families.actions', ['family' => $row]))
                ->html(),
        ];
    }

    public function bulkActions(): array
    {
        return [
            'deleteSelected' => 'Eliminar seleccionados',
        ];
    }

    public function deleteFamily($id)
    {
        $family = Family::findOrFail($id);
        $family->delete();

        $this->pruneSelection([$id]);

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Familia eliminada',
            'text'  => 'La familia se eliminó correctamente.',
        ]);
    }

    public function deleteSelected(): void
    {
        $selectedIds = collect($this->selected ?? [])->filter()->all();

        if (empty($selectedIds)) {
            return;
        }

        Family::whereIn('id', $selectedIds)->delete();

        $this->clearSelection();

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Familias eliminadas',
            'text'  => 'Los elementos seleccionados se eliminaron correctamente.',
        ]);
    }
}
