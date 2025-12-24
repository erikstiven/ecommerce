<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use App\Models\Option;
use App\Models\Feature;
use App\Models\Variant;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

class ProductVariants extends Component
{
    public $product;

    public $openModal = false;

    // public $options;

    public $variant = [
        'option_id' => '',
        'features' => [
            [
                'id' => '',
                'value' => '',
                'description' => ''
            ]
        ]
    ];

    public $variantEdit = [
        'open' => false,
        'id' => null,
        'stock' => null,
        'sku' => null,

    ];

    public $new_features = [

        // $option->id => $feature->id

    ];


    //update variant
    // public function updateVariant()
    // {
    //     $this->validate([
    //         'variantEdit.stock' => 'required|numeric',
    //         'variantEdit.sku' => 'required',
    //     ]);

    //     $variant = Variant::find($this->variantEdit['id']);
    //     $variant->update([
    //         'stock' => $this->variantEdit['stock'],
    //         'sku' => $this->variantEdit['sku'],
    //     ]);

    //     $this->reset('variantEdit');
    //     $this->product = $this->product->fresh();
    // }
    public function updateVariant()
    {
        // Validar campos obligatorios y tipos
        $this->validate([
            'variantEdit.stock' => 'required|numeric',
            'variantEdit.sku'   => 'required',
        ]);

        // Buscar la variante a editar por su ID
        $variant = Variant::find($this->variantEdit['id']);

        // Verificar que la variante exista antes de actualizarla
        if ($variant) {
            $variant->update([
                'stock' => $this->variantEdit['stock'],
                'sku'   => $this->variantEdit['sku'],
            ]);

            // Reiniciar los campos de edición y refrescar la relación del producto
            $this->reset('variantEdit');
            $this->product = $this->product->fresh();
        } else {
            // Manejar el caso de variante inexistente (opcional)
            // Por ejemplo, mostrar una alerta usando dispatch:
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => 'Variante no encontrada',
                'text'  => 'No se pudo actualizar porque la variante no existe.',
            ]);
        }
    }



    // public function mount()
    // {
    //     $this->options = Option::all();
    // }

    // Se ejecuta cuando se cambia la opción (Talla, Color, etc.)
    public function updatedVariantOptionId()
    {
        $this->variant['features'] = [
            [
                'id' => '',
                'value' => '',
                'description' => ''
            ],
        ];
    }

    #[Computed()]
    public function options()
    {
        if (! $this->product?->id) {
            return collect();
        }

        return Option::whereDoesntHave('products', function ($query) {
            $query->where('product_id', $this->product->id);
        })->get();
    }

    #[Computed()]
    public function features()
    {
        if (empty($this->variant['option_id'])) {
            return collect();
        }

        return Feature::where('option_id', $this->variant['option_id'])->get();
    }

    // public function getFeatures($options_id){

    //     $features = DB::table('option_product')
    //     ->where('product_id', $this->product->id)
    //     ->where('option_id', $options_id)
    //     ->first()->features;

    //     $features = collect(json_decode($features))->pluck('id');

    //     return Feature::where('option_id', $options_id)
    //     ->whereNotIn('id', $features)
    //     ->get();
    // }

    public function getFeatures($options_id)
    {
        $record = DB::table('option_product')
            ->where('product_id', $this->product->id)
            ->where('option_id', $options_id)
            ->first();

        // Si existe un registro y tiene la columna features, lo decodificamos; de lo contrario usamos un array vacío
        if ($record && $record->features) {
            $featureIds = collect(json_decode($record->features))->pluck('id');
        } else {
            $featureIds = collect(); // colección vacía
        }

        // Retornar las features que aún no están asociadas al producto
        return Feature::where('option_id', $options_id)
            ->whereNotIn('id', $featureIds)
            ->get();
    }


    public function addNewFeature($option_id, $feature_id)
    {
        $this->validate([
            'new_features.' . $option_id => 'required',
        ]);

        $option = $this->product->options->firstWhere('id', $option_id);
        if (! $option) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => 'Opción no encontrada',
                'text'  => 'La opción seleccionada ya no existe.',
            ]);
            return;
        }

        $feature = Feature::find($this->new_features[$option_id]);
        if (! $feature) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => 'Valor no encontrado',
                'text'  => 'El valor seleccionado ya no existe.',
            ]);
            return;
        }

        $existingFeatures = data_get($option->pivot, 'features', []);
        if (! is_array($existingFeatures)) {
            $existingFeatures = [];
        }

        $this->product->options()->updateExistingPivot($option_id, [
            'features' => array_merge($existingFeatures, [
                [
                    'id' => $feature->id,
                    'value' => $feature->value,
                    'description' => $feature->description
                ]

            ])
        ]);

        $this->product = $this->product->fresh();
        $this->new_features[$option_id] = '';


        $this->generarVariantes();
    }


    public function addFeature()
    {
        $this->variant['features'][] = [
            'id' => '',
            'value' => '',
            'description' => ''
        ];
    }

    public function feature_change($index)
    {
        $feature = Feature::find($this->variant['features'][$index]['id']);
        if ($feature) {
            $this->variant['features'][$index]['value'] = $feature->value;
            $this->variant['features'][$index]['description'] = $feature->description;
        }
    }


    public function removeFeature($index)
    {
        unset($this->variant['features'][$index]);
        $this->variant['features'] = array_values($this->variant['features']); // reindexar
    }

    //delete feature
    public function deleteFeature($option_id, $feature_id)
    {
        $option = $this->product->options->firstWhere('id', $option_id);
        if (! $option) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => 'Opción no encontrada',
                'text'  => 'La opción ya no está disponible.',
            ]);
            return;
        }

        $existingFeatures = data_get($option->pivot, 'features', []);
        if (! is_array($existingFeatures)) {
            $existingFeatures = [];
        }

        $this->product->options()->updateExistingPivot($option_id, [
            'features' => array_filter($existingFeatures, function ($feature) use ($feature_id) {
                return $feature['id'] != $feature_id;
            })
        ]);


        Variant::where('product_id', $this->product->id)
            ->whereHas('features', function ($query) use ($feature_id) {
                $query->where('features.id', $feature_id);
            })->delete();

        $this->product = $this->product->fresh();

        // $this->generarVariantes();
    }

    //deleteOption
    public function deleteOption($option_id)
    {
        $option = $this->product->options->firstWhere('id', $option_id);
        if (! $option) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => 'Opción no encontrada',
                'text'  => 'La opción ya no está asociada al producto.',
            ]);
            return;
        }

        $this->product->options()->detach($option_id);
        $this->product = $this->product->fresh();

        $this->product->variants()->delete();
        $this->generarVariantes();
    }

    // public function save()
    // {
    //     //validaciones
    //     $this->validate([
    //         'variant.option_id' => 'required',
    //         'variant.features.*.id' => 'required',
    //         'variant.features.*.value' => 'required',
    //         'variant.features.*.description' => 'required',
    //     ]);

    //     $features = collect($this->variant['features']);
    //     $features = $features->unique('id')->values()->all();


    //     $this->product->options()->attach($this->variant['option_id'], [
    //         'features' => $features
    //     ]);

    //     // $this->product = $this->product->fresh();

    //     $this->product->variants()->delete();

    //     $this->generarVariantes();


    //     $this->reset(['variant', 'openModal']);
    // }

    public function save()
    {
        // Validar que se haya seleccionado la opción y sus features
        $this->validate([
            'variant.option_id'        => 'required',
            'variant.features.*.id'    => 'required',
            'variant.features.*.value' => 'required',
            'variant.features.*.description' => 'required',
        ]);

        // Eliminar features repetidas y obtener sólo los IDs
        $features = collect($this->variant['features'])
            ->unique('id')
            ->values()
            ->map(function ($feature) {
                return [
                    'id'          => $feature['id'],
                    'value'       => $feature['value'],
                    'description' => $feature['description'],
                ];
            })
            ->all();

        $option = Option::find($this->variant['option_id']);
        if (! $option) {
            $this->dispatch('swal', [
                'icon'  => 'error',
                'title' => 'Opción no encontrada',
                'text'  => 'La opción seleccionada ya no existe.',
            ]);
            return;
        }

        // Registrar la nueva opción asociada al producto (si no existía)
        if ($this->product->options->contains('id', $option->id)) {
            $this->product->options()->updateExistingPivot(
                $option->id,
                ['features' => $features]
            );
        } else {
            $this->product->options()->attach(
                $option->id,
                ['features' => $features]
            );
        }

        // Refrescar la relación para obtener features actualizadas
        $this->product = $this->product->fresh();

        // 1) Generar todas las combinaciones válidas de features actuales
        $featuresPivot = $this->product->options
            ->pluck('pivot.features')
            ->filter()
            ->values();
        if ($featuresPivot->isEmpty()) {
            $this->reset(['variant', 'openModal']);
            return;
        }
        $combinaciones = $this->generarCombinaciones($featuresPivot);

        // 2) Recorrer variantes actuales y eliminar solo las que ya no estén en combinaciones válidas
        foreach ($this->product->variants as $variant) {
            $ids = $variant->features->pluck('id')->sort()->values()->toArray();
            if (!in_array($ids, $combinaciones)) {
                // Esta variante ya no corresponde a ninguna combinación, se elimina
                $variant->delete();
            }
        }

        // 3) Crear variantes nuevas para combinaciones que todavía no existen
        foreach ($combinaciones as $combinacion) {
            // Verificar si ya existe una variante con exactamente estas features
            $exists = Variant::where('product_id', $this->product->id)
                ->has('features', count($combinacion))
                ->whereHas('features', function ($query) use ($combinacion) {
                    $query->whereIn('features.id', $combinacion);
                })
                ->whereDoesntHave('features', function ($query) use ($combinacion) {
                    $query->whereNotIn('features.id', $combinacion);
                })
                ->first();

            if (!$exists) {
                // Crear la nueva variante y asociarle las features
                $variant = Variant::create(['product_id' => $this->product->id]);
                $variant->features()->attach($combinacion);
            }
        }

        // Resetear la entrada del formulario y cerrar el modal
        $this->reset(['variant', 'openModal']);
    }


    public function generarVariantes()
    {
        $features = $this->product->options
            ->pluck('pivot.features')
            ->filter()
            ->values();

        if ($features->isEmpty()) {
            return;
        }

        $combinaciones = $this->generarCombinaciones($features);


        foreach ($combinaciones as $combinacion) {

            $variant = Variant::where('product_id', $this->product->id)
                ->has('features', count($combinacion))
                ->whereHas('features', function ($query) use ($combinacion) {
                    $query->whereIn('features.id', $combinacion);
                })
                ->whereDoesntHave('features', function ($query) use ($combinacion) {
                    $query->whereNotIn('features.id', $combinacion);
                })->first();

            if ($variant) {
                continue;
            }

            $variant = Variant::create([
                'product_id' => $this->product->id,
            ]);
            $variant->features()->attach($combinacion);
        }
        $this->dispatch('variant-generate');
    }

    function generarCombinaciones($arrays, $indice = 0, $combinacion = [])
    {
        $arrays = is_array($arrays) ? array_values($arrays) : array_values($arrays->all());

        if ($indice == count($arrays)) {
            return [$combinacion];
        }

        $resultado = [];

        foreach ($arrays[$indice] as $item) {
            $combinacionTemporal = $combinacion;
            $combinacionTemporal[] = $item['id'];

            $resultado = array_merge($resultado, $this->generarCombinaciones($arrays, $indice + 1, $combinacionTemporal));
        }
        return $resultado;
    }

    public function editVariant(Variant $variant)
    {
        $this->variantEdit = [
            'open' => true,
            'id' => $variant->id,
            'stock' => $variant->stock,
            'sku' => $variant->sku,
        ];
    }
    public function render()
    {
        return view('livewire.admin.products.product-variants');
    }
}
