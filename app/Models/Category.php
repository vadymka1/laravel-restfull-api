<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class Category extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'categories';

    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'name', 'image', 'user_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo (User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, null, 'category_id', 'product_id');
    }


    /**
     * @return string
     */
    public function getImageLinkAttribute()
    {
        if (empty($this->attributes['image'])) {
            return '/imgs/default_category.jpg';
        }

        return '/uploads/categories/' . $this->attributes['image'];
    }

    /**
     * @param $image
     */
    public function setImageAttribute($image)
    {
        $disk = Storage::disk('category_images');

        if (isset($this->attributes['image']) && $disk->exists($this->attributes['image'])) {
            $disk->delete($this->attributes['image']);
        }

        $name = uniqid() . '.' . $image->getClientOriginalExtension();

        $disk->put($name, File::get($image));

        $this->attributes['image'] = $name;
    }

    /**
     * @return mixed
     */
    public function getCreatedAtAttribute()
    {
        dd($this->attributes['created_at']);

        return $this->attributes['created_at'];
    }
}
