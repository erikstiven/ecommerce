<?php

namespace App\Livewire\Admin\Families;

use App\Models\Family;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class FamilyTable extends DataTableComponent
{
    protected $model = Family::class;

    protected $listeners = ['deleteFamily'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTheme('tailwind');
    }

    public function builder(): Builder
    {
        return Family::query();
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
            Column::make('Acciones')
                ->label(fn($row) => view('admin.families.actions', ['family' => $row]))
                ->html(),
        ];
    }

    public function deleteFamily($id): void
    {
        $family = Family::findOrFail($id);

        if ($family->categories()->exists()) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => 'No se puede eliminar',
                'text'  => 'La familia tiene categorías asociadas.',
            ]);

            return;
        }

        $family->delete();

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Familia eliminada',
            'text'  => 'La familia se eliminó correctamente.',
        ]);
    }

    public function deleteSelected(): void
    {
        if (! $this->hasBulkSelection()) {
            return;
        }

        $this->js(<<<'JS'
            if (confirm('¿Eliminar las familias seleccionadas? Esta acción no se puede deshacer.')) {
                $wire.call('performBulkDeletion');
            }
        JS);
    }

    public function performBulkDeletion(): void
    {
        if (! $this->hasBulkSelection()) {
            return;
        }

        $families = Family::withCount('categories')->whereIn('id', $this->selected)->get();

        $blocked = $families->filter(fn($family) => $family->categories_count > 0);
        $deletable = $families->where('categories_count', 0);

        foreach ($deletable as $family) {
            $family->delete();
        }

        $this->clearBulkSelection();

        if ($blocked->isNotEmpty()) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => 'Algunas familias no se pudieron eliminar',
                'text'  => 'Hay familias con categorías asociadas.',
            ]);

            return;
        }

        $this->dispatch('swal', [
            'icon'  => 'success',
            'title' => 'Familias eliminadas',
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
