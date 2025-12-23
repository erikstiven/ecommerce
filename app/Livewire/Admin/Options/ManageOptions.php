<?php

namespace App\Livewire\Admin\Options;


use App\Livewire\Forms\Admin\Options\NewOptionForm;
use App\Models\Feature;
use App\Models\Option;
use App\Models\Variant;

use Livewire\Component;
use Livewire\Attributes\On;

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
        if (!$feature->exists) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => 'Característica no encontrada',
                'text'  => 'No se pudo eliminar la característica seleccionada.',
            ]);
            return;
        }

        $option = $feature->option;
        if ($option) {
            $option->loadMissing('products');

            foreach ($option->products as $product) {
                $pivotOption = $product->options->firstWhere('id', $option->id);
                if (!$pivotOption) {
                    continue;
                }

                $currentFeatures = data_get($pivotOption->pivot, 'features', []);
                $currentFeatures = is_array($currentFeatures) ? $currentFeatures : [];

                $filtered = array_values(array_filter($currentFeatures, function ($item) use ($feature) {
                    return ($item['id'] ?? null) !== $feature->id;
                }));

                $product->options()->updateExistingPivot($option->id, [
                    'features' => $filtered,
                ]);
            }
        }

        Variant::whereHas('features', function ($query) use ($feature) {
            $query->where('features.id', $feature->id);
        })->delete();

        $feature->variants()->detach();
        $feature->delete();
        $this->options = Option::with('features')->get();
    }
    //delete option
    public function deleteOption(Option $option)
    {
        if (!$option->exists) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => 'Opción no encontrada',
                'text'  => 'No se pudo eliminar la opción seleccionada.',
            ]);
            return;
        }

        $option->loadMissing(['features', 'products']);

        $featureIds = $option->features->pluck('id')->all();
        foreach ($option->products as $product) {
            $product->options()->detach($option->id);

            if (!empty($featureIds)) {
                $product->variants()
                    ->whereHas('features', function ($query) use ($featureIds) {
                        $query->whereIn('features.id', $featureIds);
                    })->delete();
            }
        }

        foreach ($option->features as $feature) {
            $feature->variants()->detach();
            $feature->delete();
        }

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
