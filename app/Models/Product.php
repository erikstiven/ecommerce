<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'sku',
        'name',
        'description',
        'image_path',
        'price',
        'subcategory_id',
    ];

    //

    // Product.php

    public function scopeFilterByFamily($query, $familyId)
    {
        return $query->when($familyId, function ($query) use ($familyId) {
            $query->whereHas('subcategory.category', function ($q) use ($familyId) {
                $q->where('family_id', $familyId);
            });
        });
    }

    public function scopeFilterByCategory($query, $categoryId)
    {
        return $query->when($categoryId, function ($query) use ($categoryId) {
            $query->whereHas('subcategory', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        });
    }

    public function scopeFilterBySubcategory($query, $subcategoryId)
    {
        return $query->when($subcategoryId, fn($q) => $q->where('subcategory_id', $subcategoryId));
    }

    public function scopeFilterByFeatures($query, $features)
    {
        return $query->when(!empty($features), function ($query) use ($features) {
            $query->whereHas('variants.features', function ($q) use ($features) {
                $q->whereIn('features.id', $features);
            });
        });
    }

    public function scopeApplyOrdering($query, $orderBy)
    {
        return match ((int) $orderBy) {
            1 => $query->orderBy('created_at', 'desc'),
            2 => $query->orderBy('price', 'desc'),
            3 => $query->orderBy('price', 'asc'),
            default => $query,
        };
    }

    public function scopeSearchByName($query, $search)
    {
        return $query->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"));
    }




    public function image(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::url($this->image_path),
        );
    }



    //Relacion uno a muchoS inversa
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    //Relacion uno a muchos
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
    //Relacion muchos a muchos
    public function options()
    {
        return $this->belongsToMany(Option::class)
            ->using(OptionProduct::class)
            ->withPivot('features')
            ->withTimestamps();
    }
}
