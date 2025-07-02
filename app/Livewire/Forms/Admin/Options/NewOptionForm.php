<?php

namespace App\Livewire\Forms\Admin\Options;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Option;

class NewOptionForm extends Form
{
    public $name;
    public $type = 1; // 1: Texto, 2: Color
    public $features = [
        [
            'value' => '',
            'description' => '',
        ],
    ];

    public $openModal = false;

    public function rules()
    {
        $rules = [
            'name' => 'required',
            'type' => 'required|in:1,2',
            'features' => 'required|array|min:1',
        ];

        foreach ($this->features as $index => $feature) {
            // $rules["newOption.features.$index.value"] = 'required';
            if ($this->type == 1) {
                $rules["features.$index.value"] = 'required';
            } else {
                $rules["features.$index.value"] = 'required|regex:/^#[0-9A-Fa-f]{6}$/'; // Validación de color hexadecimal
            }
            $rules["features.$index.description"] = 'required|max:255';
        }
        return $rules;
    }

    //validacion de atributos
    public function validationAttributes()
    {
        $attributes = [
            'name' => 'nombre',
            'type' => 'tipo',
            'features' => 'valores',
        ];

        if (is_array($this->features)) {
            foreach ($this->features as $index => $feature) {
                $attributes['features.' . $index . '.value'] = 'valor ' . ($index + 1);
                $attributes['features.' . $index . '.description'] = 'descripción ' . ($index + 1);
            }
        }

        return $attributes;
    }



    public function addFeature()
    {
        $this->features[] = [
            'value' => '',
            'description' => '',
        ];
    }

    public function removeFeature($index)
    {
        unset($this->features[$index]);
        $this->features = array_values($this->features);
    }

    //metodo save
    public function save()
    {
        $this->validate();

        $option = Option::create([
            'name' => $this->name,
            'type' => $this->type,
        ]);
        foreach ($this->features as $feature) {
            $option->features()->create([
                'value' => $feature['value'],
                'description' => $feature['description'],
            ]);
        }

        $this->reset();
    }
}
