<?php

namespace App\Service;

use App\User;
use App\ValueObject\Id;

class SessionUserStorage
{
    private const KEY = 'users';

    public function checkAndCreate(): void
    {
        if (!isset($_SESSION[self::KEY]) || !is_array($_SESSION[self::KEY])) {
            $_SESSION[self::KEY] = [];
        }
    }

    public function save(User $user): void
    {
        $id = (string)$user->getId();
        $_SESSION[self::KEY][$id] = serialize($user);
    }

    public function getAll(): array
    {
        return $_SESSION[self::KEY];
    }

    public function delete($key): void
    {
        unset($_SESSION[self::KEY][$key]);
    }

}