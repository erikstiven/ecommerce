<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Family;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Navegation extends Component
{

    public $families;

    public $family_id;
    public function mount()
    {
        $this->families = Family::all();
        $this->family_id = $this->families->first()?->id;
    }

    #[Computed()]
    public function categories()
    {
        if (! $this->family_id) {
            return collect();
        }

        return Category::where('family_id', $this->family_id)
            ->with('subcategories')
            ->get();
    }

    #[Computed()]

    public function familyName()
    {
        if (! $this->family_id) {
            return '';
        }

        return Family::find($this->family_id)?->name ?? '';
    }


    public function render()
    {
        return view('livewire.navegation');
    }
}
