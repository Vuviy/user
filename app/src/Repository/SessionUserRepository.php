<?php

namespace App\Repository;

use App\User;
use App\ValueObject\Email;
use App\ValueObject\Id;


/**
 * repository by sessions
 *
 * structure $_SESSION['users'] :
 *   ['<id>' => '<serialized string>', ...]
 */
final class SessionUserRepository implements UserRepositoryInterface
{
    private const KEY = 'users';

    public function __construct()
    {
//        unset($_SESSION[self::KEY]);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION[self::KEY]) || !is_array($_SESSION[self::KEY])) {
            $_SESSION[self::KEY] = [];
        }
    }
    public function save(User $user): void
    {
        $id = (string) $user->getId();
        $_SESSION[self::KEY][$id] =  serialize($user);
    }

    public function getAll(): array
    {
        return $_SESSION[self::KEY];
    }

    public function getByEmail(Email $email): ?User
    {
        foreach ($_SESSION[self::KEY] as $serialized) {
            $user = unserialize($serialized);
            if (! $user instanceof User) {
                continue;
            }
            if ((string)$user->getEmail() === (string)$email) {
                return $user;
            }
        }
        return null;
    }

    public function getById(Id $id): ?User
    {
        $key = (string)$id;
        if (!array_key_exists($key, $_SESSION[self::KEY])) {
            return null;
        }

        $user = unserialize($_SESSION[self::KEY][$key]);
        if (!$user instanceof User) {
            return null;
        }
        return $user;
    }

    public function delete(Id $id): void
    {
        $key = (string)$id;
        unset($_SESSION[self::KEY][$key]);
    }
}