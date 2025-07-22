<?php

namespace App\Livewire;

use App\Livewire\Forms\CreateAddressForm;
use App\Livewire\Forms\Shpping\EditAddressForm;
use App\Models\Address;
use Livewire\Component;


class ShippingAddresses extends Component
{
    public $addresses;

    public $newAddress = false;

    public CreateAddressForm $createAddress;
    //EditAddressForm
    public EditAddressForm $editAddress;


    //mount 
    public function mount()
    {
        $this->addresses = Address::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->get();

        $this->createAddress->receiver_info = [
            'name' => \Illuminate\Support\Facades\Auth::user()->name,
            'last_name' => \Illuminate\Support\Facades\Auth::user()->last_name,
            'document_type' => \Illuminate\Support\Facades\Auth::user()->document_type,
            'document_number' => \Illuminate\Support\Facades\Auth::user()->document_number,
            'phone' => \Illuminate\Support\Facades\Auth::user()->phone,
        ];
    }

    public function store()
    {
        $this->createAddress->save();

        $this->addresses = Address::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->get();

        $this->newAddress = false;
    }

    public function edit($id){
        $address = Address::find($id);
        $this->editAddress->edit($address);
    }

    public function update(){
        $this->editAddress->update();

        $this->addresses = Address::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->get();

        
    }

    //delete address
    public function deleteAddress($id)
    {
        Address::find($id)->delete();
        $this->addresses = Address::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->get();

        if ($this->addresses->where('default', true)->count() === 0 && $this->addresses->count() > 0) {
            $this->addresses->first()->update(['default' => true]);
        }
    }

    public function setDefaultAddress($id)
{
    $this->addresses->each(function ($address) use ($id) {
        $address->update([
            'default' => $address->id === $id
        ]);
    });

    // 🔥 SOLUCIÓN: recargar direcciones desde la base de datos
    $this->addresses = Address::where('user_id', \Illuminate\Support\Facades\Auth::user()->id)->get();
}

    



    public function render()
    {

        return view('livewire.shipping-addresses');
    }
}
