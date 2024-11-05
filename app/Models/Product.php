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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
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
    return $this->belongsToMany(Sale::class, 'sale_product')->withPivot('quantity', 'price')->withTimestamps();
}

public function orders()
{
    return $this->belongsToMany(Order::class,  'order_product')->withPivot('price');
}

public function saleProducts()
{
    return $this->hasMany(SaleProduct::class);
}

}
