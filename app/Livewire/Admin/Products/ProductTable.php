<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ProductTable extends Component
{
    use WithPagination;

    public string $search = '';

    public int $perPage = 10;

    public string $sortField = 'id';

    public string $sortDirection = 'desc';

    /**
     * Selected product IDs.
     *
     * @var array<int>
     */
    public array $selected = [];

    public bool $selectAll = false;

    public array $visibleColumns = [
        'id' => true,
        'sku' => true,
        'name' => true,
        'price' => true,
    ];

    protected $listeners = [
        'deleteProduct' => 'deleteProduct',
        'deleteSelected' => 'deleteSelected',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'id'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
    ];

    protected string $paginationTheme = 'tailwind';

    public function render()
    {
        $products = $this->query()->paginate($this->perPage);

        return view('livewire.admin.products.product-table', [
            'products' => $products,
        ]);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
        $this->clearSelection();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
        $this->clearSelection();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function updatedPage(): void
    {
        $this->updatedSelected();
    }

    public function updatedSelectAll(bool $value): void
    {
        $pageIds = $this->pageProductIds();

        if ($value) {
            $this->selected = array_values(array_unique(array_merge($this->selected, $pageIds)));
        } else {
            $this->selected = array_values(array_diff($this->selected, $pageIds));
        }

        $this->normalizeSelected();
    }

    public function updatedSelected(): void
    {
        $this->normalizeSelected();

        $pageIds = $this->pageProductIds();
        $this->selectAll = !empty($pageIds) && count(array_intersect($pageIds, $this->selected)) === count($pageIds);
    }

    public function toggleColumn(string $key): void
    {
        if (! array_key_exists($key, $this->visibleColumns)) {
            return;
        }

        $this->visibleColumns[$key] = ! $this->visibleColumns[$key];
    }

    public function deleteProduct(int $id): void
    {
        $product = Product::findOrFail($id);

        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        $this->selected = array_values(array_diff($this->selected, [$id]));
        $this->updatedSelected();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Producto eliminado',
            'text' => 'El producto se eliminó correctamente.',
        ]);
    }

    public function deleteSelected(): void
    {
        if (empty($this->selected)) {
            return;
        }

        $products = Product::whereIn('id', $this->selected)->get();

        foreach ($products as $product) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }

            $product->delete();
        }

        $this->clearSelection();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Productos eliminados',
            'text' => 'Los elementos seleccionados se eliminaron correctamente.',
        ]);
    }

    public function clearSelection(): void
    {
        $this->selected = [];
        $this->selectAll = false;
    }

    protected function normalizeSelected(): void
    {
        $this->selected = array_values(array_unique(array_map('intval', $this->selected)));
    }

    protected function query(): Builder
    {
        $term = $this->search;
        $likeTerm = "%{$term}%";

        return Product::query()
            ->when($term, function (Builder $query) use ($likeTerm, $term) {
                $query->where(function (Builder $subQuery) use ($likeTerm, $term) {
                    $subQuery
                        ->where('name', 'like', $likeTerm)
                        ->orWhere('sku', 'like', $likeTerm);

                    if (is_numeric($term)) {
                        $subQuery->orWhere('id', (int) $term);
                    }
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    /**
     * IDs for the current page, respecting filters and sorting.
     *
     * @return array<int>
     */
    protected function pageProductIds(): array
    {
        $query = $this->query();

        return (clone $query)
            ->select('id')
            ->forPage($this->page ?? 1, $this->perPage)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();
    }
}
