<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Family extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',

    ];

    //Relacion uno a muchos
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
