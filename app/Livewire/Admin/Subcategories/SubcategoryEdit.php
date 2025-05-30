<?php

namespace App\Livewire\Admin\Subcategories;

use Livewire\Component;
use App\Models\Family;
use Livewire\Attributes\Computed;
use App\Models\Category;


class SubcategoryEdit extends Component
{
    public $subcategory;
    public $families;

    public $subcategoryEdit;

    public function mount($subcategory)
    {
        $this->families = Family::all();

        $this->subcategoryEdit = [
            'family_id' => $subcategory->category->family_id,
            'category_id' => $subcategory->category_id,
            'name' => $subcategory->name,
        ];
    }

     //propiedad computada
    #[Computed()]
    public function categories()
    {
        return Category::where('family_id', $this->subcategoryEdit['family_id'])->orderBy('name')->get();
    }

      public function updatedSubcategoryEditFamilyId($value)
    {
        $this->subcategoryEdit['category_id'] = '';
    }

    public function save()
    {
        $this->validate(
            [
                'subcategoryEdit.family_id' => 'required|exists:families,id',
                'subcategoryEdit.category_id' => 'required|exists:categories,id',
                'subcategoryEdit.name' => 'required',
            ],
            [],
            [
                'subcategoryEdit.family_id' => 'Familia',
                'subcategoryEdit.category_id' => 'Categoría',
                'subcategoryEdit.name' => 'Nombre',
            ]
        );

        $this->subcategory->update($this->subcategoryEdit);

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Subcategoria Actualizada Correctamente',
        ]);

    }


    public function render()
    {
        return view('livewire.admin.subcategories.subcategory-edit');
    }
}
