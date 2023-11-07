<?php

namespace Controller;

use Model\Post;
use Model\Product;
use Model\User;
use Src\Auth\ApiAuth;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class Api
{
    public function index(): void
    {
        $posts = Post::all()->toArray();

        (new View())->toJSON($posts);
    }

    public function echo(Request $request): void
    {
        (new View())->toJSON($request->all());
    }

    public function signup(Request $request): void
    {
        $validator = new Validator($request->all(), [
            'email' => ['required', 'emailValid', 'unique:users,email'],
            'fio' => ['required'],
            'password' => ['required']
        ], [
            'required' => 'Поле :field пусто',
            'unique' => 'Поле :field должно быть уникально',
            'emailValid' => 'Email не корректный'
        ]);

        if($validator->fails()){
            (new View())->toJSON($validator->errors());
            return;
        }

        $request->set('auth_token', sha1(random_bytes(100)) . sha1(random_bytes(100)));
        User::create($request->all());

        (new View())->toJSON(['user_token' => $request->get('auth_token')]);

    }


    public function login(Request $request): void
    {

        $user = User::attemptIdentity($request->all());
        if (!$user){
            (new View())->toJSON(['error' => 'Неправильный емейл или пароль']);
            return;
        }

        $token = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->auth_token = $token;
        $user->save();

        (new View())->toJSON(['user_token' => $token]);
    }

    public function logout(Request $request): void
    {
        try {
            $user = ApiAuth::tokenAuth($request);
        } catch (\Exception $error) {
            (new View())->toJSON(['error' => $error->getMessage()]);
            return;
        }

        $user->auth_token = null;
        $user->save();

        (new View())->toJSON(['message' => 'logout']);
    }

    public function getProducts(): void
    {
        $product = Product::all()->toArray();

        (new View())->toJSON($product);
    }
}
