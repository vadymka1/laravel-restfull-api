<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class Product_images extends Model
{
    protected $table = 'product_images';

    protected $fillable = [
        'name', 'main', 'product_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    /**
     * @param $image
     */
    public function setImageAttribute($image)
    {
        $name = uniqid() . '.' . $image->getClientOriginalExtension();

        Storage::disk('product_images')->put($name, File::get($image));

        $this->attributes['image'] = $name;
    }
}