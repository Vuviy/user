<?php

namespace App\Repository;

use App\Service\SessionUserStorage;
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
    private SessionUserStorage $sessionUserStorage;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->sessionUserStorage = new SessionUserStorage();

        $this->sessionUserStorage->checkAndCreate();

    }

    public function save(User $user): void
    {
        $this->sessionUserStorage->save($user);
    }

    public function getAll(): array
    {
        return $this->sessionUserStorage->getAll();
    }

    public function getByEmail(Email $email): ?User
    {
        $users = $this->sessionUserStorage->getAll();
        foreach ($users as $serialized) {
            $user = unserialize($serialized);
            if (!$user instanceof User) {
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
        $users = $this->sessionUserStorage->getAll();
        $key = (string)$id;
        if (!array_key_exists($key, $users)) {
            return null;
        }

        $user = unserialize($users[$key]);
        if (!$user instanceof User) {
            return null;
        }
        return $user;
    }

    public function delete(Id $id): void
    {
        $key = (string)$id;
        $this->sessionUserStorage->delete($key);
    }
}