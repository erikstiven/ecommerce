<?php

namespace App\Livewire\Forms;

use App\Enums\TypeOfDocuments;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Validate;
use Livewire\Form;


class CreateAddressForm extends Form
{
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

    //rules

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

    //save
    public function save()
    {
        $this->validate();

        if (Auth::user()->addresses->count() == 0) {
            $this->default = true;
        }

        Address::create([
            'user_id' => \Illuminate\Support\Facades\Auth::user()->id,
            'type' => $this->type,
            'description' => $this->description,
            'province' => $this->province,
            'city' => $this->city,
            'reference' => $this->reference,
            'receiver' => $this->receiver,
            'receiver_info' => $this->receiver_info,
            'default' => $this->default,

        ]);

        $this->reset();

        $this->receiver_info = [
            'name' => \Illuminate\Support\Facades\Auth::user()->name,
            'last_name' => \Illuminate\Support\Facades\Auth::user()->last_name,
            'document_type' => \Illuminate\Support\Facades\Auth::user()->document_type,
            'document_number' => \Illuminate\Support\Facades\Auth::user()->document_number,
            'phone' => \Illuminate\Support\Facades\Auth::user()->phone,
        ];
    }
}
