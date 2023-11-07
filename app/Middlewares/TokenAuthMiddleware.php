<?php

namespace Middlewares;

use Src\Request;

class TokenAuthMiddleware
{
    public function handle(Request $request)
    {
        $request->set('aaaaaa', 'bbbbbbbbbbbbbb');
        return $request;
    }
}
