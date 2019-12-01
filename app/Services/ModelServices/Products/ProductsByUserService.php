<?php

namespace App\Services\ModelServices\Products;

use App\Models\User;

class ProductsByUserService
{
    /**
     * @param User $user
     * @return mixed
     */
    public function run(User $user)
    {
        $products = $user->products;

        return $products;
    }
}