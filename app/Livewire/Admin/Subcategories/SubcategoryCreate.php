<?php

namespace App\Livewire\Admin\Subcategories;

use App\Models\Category;
use Livewire\Component;
use App\Models\Family;
use App\Models\Subcategory;
use Livewire\Attributes\Computed;

class SubcategoryCreate extends Component
{
    public $families;

    public $subcategory = [
        'family_id' => '',
        'category_id' => '',
        'name' => '',
    ];

    public function mount()
    {
        $this->families = Family::all();
    }

    public function updatedSubcategoryFamilyId($value)
    {
        $this->subcategory['category_id'] = '';
    }


    //propiedad computada
    #[Computed()]
    public function categories()
    {
        return Category::where('family_id', $this->subcategory['family_id'])
            ->orderBy('name')
            ->get();
    }

    public function save()
    {

        $this->validate(
            [
                'subcategory.family_id' => 'required|exists:families,id',
                'subcategory.category_id' => 'required|exists:categories,id',
                'subcategory.name' => 'required',
            ],
            [],
            [
                'subcategory.family_id' => 'Familia',
                'subcategory.category_id' => 'Categoría',
                'subcategory.name' => 'Nombre',
            ]
        );
        Subcategory::create($this->subcategory);

         session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Subcategoria Actualizada Correctamente',
        ]);

        return redirect()->route('admin.subcategories.index');
    }
    public function render()
    {
        return view('livewire.admin.subcategories.subcategory-create');
    }
}
