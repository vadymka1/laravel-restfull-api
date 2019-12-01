<?php

namespace App\Services\ModelServices\Products;

use App\Models\Category;

class ProductsByCategoryService
{
    /**
     * @param Category $category
     * @return mixed
     */
    public function run(Category $category)
    {
        $products = $category->products;

        return $products;
    }
}