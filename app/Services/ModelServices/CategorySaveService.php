<?php

namespace App\Services\ModelServices;

use App\Models\Category;

class CategorySaveService
{
    /**
     * @param Category $category
     * @param array $data
     * @return bool
     */
    public function run (Category $category, array $data) : bool
    {
        $category->forceFill($data);

        return $category->save();
    }
}