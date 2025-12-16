<?php

namespace App\Livewire\Admin\Tables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;

abstract class BaseAdminTable extends DataTableComponent
{
    /** @var array<int, int|string> */
    public array $selected = [];

    /**
     * Shared pagination sizes for all admin tables.
     */
    protected array $perPageAccepted = [10, 25, 50, 100];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTheme('tailwind');

        $this->setPerPageAccepted($this->perPageAccepted);
        $this->setPerPageVisibilityEnabled();
        $this->setColumnSelectEnabled();
    }

    public function updatedSelected(): void
    {
        $this->dispatchSelectionCount();
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
        if (empty($this->selected)) {
            return;
        }

        $this->selected = array_values(array_diff($this->selected, $ids));
        $this->dispatchSelectionCount();
    }
}
