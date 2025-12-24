<?php

namespace App\Livewire\Admin\Options;


use App\Livewire\Forms\Admin\Options\NewOptionForm;
use App\Models\Feature;
use App\Models\Option;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class ManageOptions extends Component
{
    public $options;
    public NewOptionForm $newOption;

    public function mount()
    {
        $this->options = Option::with('features')->get();
    }
    #[On('featureAdded')]

    //actualizar lista de opciones
    public function updateOptionList()
    {
        $this->options = Option::with('features')->get();
    }

    public function addFeature()
    {
        $this->newOption->addFeature();
    }

    //remover feature
    public function removeFeature($index)
    {
        $this->newOption->removeFeature($index);
    }


    public function deleteFeature(Feature $feature)
    {
        if (! $feature->exists) {
            return;
        }

        $optionId = $feature->option_id;
        if ($optionId) {
            $pivotRows = DB::table('option_product')
                ->where('option_id', $optionId)
                ->get();

            foreach ($pivotRows as $row) {
                $features = collect(json_decode($row->features, true) ?: [])
                    ->filter(function ($item) use ($feature) {
                        return data_get($item, 'id') !== $feature->id;
                    })
                    ->values()
                    ->all();

                DB::table('option_product')
                    ->where('product_id', $row->product_id)
                    ->where('option_id', $optionId)
                    ->update(['features' => json_encode($features)]);
            }
        }

        $feature->variants()->detach();
        $feature->delete();
        $this->options = Option::with('features')->get();
    }
    //delete option
    public function deleteOption(Option $option)
    {
        if (! $option->exists) {
            return;
        }

        $option->features->each(function (Feature $feature) {
            $feature->variants()->detach();
        });
        $option->features()->delete();
        $option->products()->detach();
        $option->delete();
        $this->options = Option::with('features')->get();
    }

    public function addOption()
    {
        $this->newOption->save();


        $this->options = Option::with('features')->get();


        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Opción creada correctamente',
            'text' => 'La opción ha sido creada exitosamente.',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.options.manage-options');
    }
}
