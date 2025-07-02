<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',

    ];
    //Relacion muchos a muchos
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->using(OptionProduct::class)
            ->withPivot('features')
            ->withTimestamps();
    }
    //Relacion uno a muchos
    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}
