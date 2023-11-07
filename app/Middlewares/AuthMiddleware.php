<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class AuthMiddleware
{
    public function handle(Request $request)
    {
        //Если пользователь не авторизован, то редирект на страницу входа
        $request->set('aaaaaa', 'bbbbbbbbbbbbbb');
//        if (!Auth::check()) {
//            app()->route->redirect('/login');
//        }
        return $request;
    }
}
