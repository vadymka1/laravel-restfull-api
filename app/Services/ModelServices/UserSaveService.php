<?php
namespace App\Services\ModelServices;

use App\Models\User;

class UserSaveService
{
    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function run(User $user, array $data) : bool
    {
        $user->forceFill($data);

        return $user->save();
    }
}