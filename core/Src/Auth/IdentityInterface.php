<?php

namespace Src\Auth;

interface IdentityInterface
{
    public function findIdentity(int $id);

    public function getId(): int;

    public static function attemptIdentity(array $credentials);
}
