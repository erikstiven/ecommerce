<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use App\Models\Family;
use Livewire\Attributes\Computed;
use App\Models\Category;
use App\Models\Subcategory;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;

class ProductEdit extends Component
{
    use WithFileUploads;

    public $product;
    public $productEdit;

    public $families;
    public $family_id = '';
    public $category_id = '';

    public $image;

    public function mount($product)
    {
        $this->product = $product; // Asignar el producto completo
        $this->productEdit = $product->only('sku', 'name', 'description', 'image_path', 'price', 'subcategory_id');

        $this->families = Family::all();

        $this->category_id = $product->subcategory->category->id;
        $this->family_id = $product->subcategory->category->family->id;
    }

    public function boot()
    {
        $this->withValidator(function ($validator) {
            if ($validator->fails()) {
                $this->dispatch('swal', [
                    'icon' => 'error',
                    'title' => '¡Error!',
                    'text' => 'Por favor, corrige los errores en el formulario.',
                ]);
            }
        });
    }

    public function updatedFamilyId($value)
    {
        $this->category_id = '';
        $this->productEdit['subcategory_id'] = '';
    }

    public function updatedCategoryId($value)
    {
        $this->productEdit['subcategory_id'] = '';
    }

    //propiedades computadas
    #[Computed()]
    public function categories()
    {
        return Category::where('family_id', $this->family_id)->get();
    }

    #[On('variant-generate')]
    public function updateProduct()
    {
        $this->product = $this->product->fresh();
    }

    #[Computed()]
    public function subcategories()
    {
        return Subcategory::where('category_id', $this->category_id)->get();
    }

    public function store()
    {
        $this->validate([
            'image' => 'nullable|image|max:1024', // 1MB Max
            'productEdit.sku' => 'required|unique:products,sku,' . $this->product->id,
            'productEdit.name' => 'required|max:255',
            'productEdit.description' => 'nullable',
            'productEdit.price' => 'required|numeric|min:0',
            'productEdit.subcategory_id' => 'required|exists:subcategories,id',
        ]);

        // Solo procesar imagen si se subió una nueva
        if ($this->image) {
            // Eliminar imagen anterior si existe
            if ($this->productEdit['image_path']) {
                //Storage::delete($this->productEdit['image_path']);
                Storage::disk('public')->delete($this->productEdit['image_path']);
            }

            // Guardar nueva imagen
            //$this->productEdit['image_path'] = $this->image->store('products');
            $this->productEdit['image_path'] = $this->image->store('products', 'public');

        }

        $allowedAttributes = [
            'sku',
            'name',
            'description',
            'image_path',
            'price',
            'subcategory_id',
        ];

        $this->product->update(array_intersect_key(
            $this->productEdit,
            array_flip($allowedAttributes)
        ));

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Producto Actualizado!',
            'text' => 'El producto se actualizó correctamente.',
        ]);

        return redirect()->route('admin.products.edit', $this->product);
    }

    public function render()
    {
        return view('livewire.admin.products.product-edit');
    }
}
