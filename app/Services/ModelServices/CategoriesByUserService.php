<?php

namespace App\Services\ModelServices;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class CategoriesByUserService
{
    public function run(User $user)
    {
        $categories = $user->categories;

        return $categories;
    }
}