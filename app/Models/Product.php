<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Product extends Model
{
    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'name', 'user_id', 'description'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(
            Category::class, 'categories_products',
            'product_id', 'category_id' );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Product_images::class);
    }

    /**
     * @return string
     */
    public function getMainImage ()
    {
        $image = $this->images()->where('main', 1)->first();
        if(empty($image)) {
            return '/imgs/default_product.png';
        }

        return '/uploads/products/' . $image->image;
    }
}
