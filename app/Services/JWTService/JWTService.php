<?php

namespace App\Services\JWTService;

use Tymon\JWTAuth\Facades\JWTAuth;

class JWTService
{
    /**
     * @return bool|false|\Tymon\JWTAuth\Contracts\JWTSubject
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function checkAuthUser()
    {
        $token = JWTAuth::parseToken();

        if($token) {
            $user = JWTAuth::toUser($token);
            return $user;
        }
        return false;
    }

    /**
     * @param string $token
     * @return false|\Tymon\JWTAuth\Contracts\JWTSubject
     */
    public function getAuthUser(string $token)
    {
        $user = JWTAuth::toUser($token);

        return $user;
    }
}