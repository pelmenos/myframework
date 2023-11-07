<?php

namespace Src\Auth;

use Model\User;
use Src\Request;


class ApiAuth
{
    public static function tokenAuth(Request $request)
    {
        if (!array_key_exists('Authorization', $request->headers)){
            throw new \Exception('Token was not given');
        }

        $splited = explode(' ', $request->headers['Authorization']);
        if (count($splited) != 2 && $splited[0] != 'Bearer'){
            throw new \Exception('Token is not valid');
        }

        $user = User::getByToken($splited[1]);
        if (!$user){
            throw new \Exception('Unauthorized token');
        }

        return $user;
    }

}
