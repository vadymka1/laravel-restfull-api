<?php

namespace App\Services\ModelServices\Products;

use App\Models\Product;

class ProductSaveService
{
    /**
     * @param Product $product
     * @param array $data
     * @param array $categories
     * @return array|bool
     */
    public function run(Product $product , array $data, array $categories)
    {
        $product->forceFill($data);

        if($product->save()){
            return $product->categories()->sync($categories);
        };

        return false;
    }
}