<?php

// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'category_id',
        'tag_ids',
        'inventory_level',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
{
    return $this->belongsToMany(Tag::class, 'product_tag');
}

public function inventory()
{
    return $this->hasMany(Inventory::class);
}


public function sales()
{
    return $this->belongsToMany(Sale::class, 'sale_product')->withPivot('quantity', 'price')->withTimestamps();;
}

}
