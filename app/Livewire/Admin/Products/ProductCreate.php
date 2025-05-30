<?php

namespace App\Livewire\Admin\Products;

use App\Models\Family;
use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Category;

class ProductCreate extends Component
{
    public $families;
    public $family_id = '';

    public $product = [
        'sku' => '',
        'name' => '',
        'description' => '',
        'image_path' => '',
        'price' => '',
        'subcategory_id' => '',
    ];

    public function mount()
    {
        $this->families = Family::all();
    }
    //propiedad computada
    #[Computed()]
    public function categories(){
        return Category::where('family_id', $this->family_id)->get();

    }
    public function render()
    {
        return view('livewire.admin.products.product-create');
    }
}
