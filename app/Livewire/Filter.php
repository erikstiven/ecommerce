<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Filter extends Component
{
    use WithPagination;

    public $family_id;

    public $category_id;

    public $subcategory_id;


    public $options;

    public $selected_features = [];

    public $orderBy = 1;

    public $search;

    public function mount()
    {
        $this->options = Option::verifyFamily($this->family_id)
            ->verifyCategory($this->category_id)
            ->verifySubcategory($this->subcategory_id)
            ->get()->toArray();
    }

    #[On('search')]
    public function search($search)
    {
        $this->search = $search;
    }

    public function render()
    {
        $products = Product::query()
            ->filterByFamily($this->family_id)
            ->filterByCategory($this->category_id)
            ->filterBySubcategory($this->subcategory_id)
            ->filterByFeatures($this->selected_features)
            ->searchByName($this->search)
            ->applyOrdering($this->orderBy)
            ->paginate(12);

        return view('livewire.filter', compact('products'));
    }
}
