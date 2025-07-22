<?php

namespace App\Livewire\Forms\Shpping;

use App\Enums\TypeOfDocuments;
use App\Models\Address;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EditAddressForm extends Form
{
    //id
    public $id;
    public $type = '';
    public $description = '';
    public $province = '';
    public $city = '';
    public $reference = '';
    //receiver
    public $receiver = 1;
    //receiver_info
    public $receiver_info = [];
    //default
    public $default = false;

    public function rules()
    {
        return [
            'type' => 'required|in:1,2',
            'description' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'reference' => 'required|string',
            'receiver' => 'required|in:1,2',
            'receiver_info.name' => 'required|string',
            'receiver_info.last_name' => 'required|string',
            'receiver_info.document_type' => [
                'required',
                new Enum(TypeOfDocuments::class),
            ],
            'receiver_info.document_number' => 'required|string',
            'receiver_info.phone' => 'required|string',
        ];
    }

    //traducir errors
    public function validationAttributes()
    {
        return [
            'type' => 'tipo de dirección',
            'description' => 'nombre de la dirección',
            'province' => 'provincia',
            'city' => 'ciudad',
            'reference' => 'referencia',
            'receiver_info.name' => 'nombres del receptor',
            'receiver_info.last_name' => 'apellidos del receptor',
            'receiver_info.document_type' => 'tipo de documento del receptor',
            'receiver_info.document_number' => 'número de documento del receptor',
            'receiver_info.phone' => 'teléfono del receptor',
        ];
    }

    //metodo edit
    public function edit($address)
    {
        $this->id = $address->id;
        $this->type = $address->type;
        $this->description = $address->description;
        $this->province = $address->province;
        $this->city = $address->city;
        $this->reference = $address->reference;
        $this->receiver = $address->receiver;
        $this->receiver_info = $address->receiver_info;
        $this->default = $address->default;
    }

    //update
    public function update()
    {
        $this->validate();
        
        $address = Address::find($this->id);
        $address->update([
            'type' => $this->type,
            'description' => $this->description,
            'province' => $this->province,
            'city' => $this->city,
            'reference' => $this->reference,
            'receiver' => $this->receiver,
            'receiver_info' => $this->receiver_info,
            'default' => $this->default,
        ]);

        // Reset the form
        $this->reset();
    }
}
