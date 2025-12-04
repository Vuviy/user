<?php

namespace App\Service;

use App\Repository\UserRepositoryInterface;
use App\RoleFactory;
use App\User;
use App\ValueObject\Email;
use App\ValueObject\Id;
use App\ValueObject\Password;
use App\ValueObject\Role;
use InvalidArgumentException;

final class AuthService
{

    private const AUTH_KEY = 'auth_user_id';

    public function __construct(private UserRepositoryInterface $repo)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function register(string $emailString, string $plainPassword, array $roles = []): User
    {
        $email = new Email($emailString);

        if ($this->repo->getByEmail($email) !== null) {
            throw new InvalidArgumentException('User with this email already exists.');
        }

        $id = new Id($this->generateFakeUuid());

        $password = Password::fromPlain($plainPassword);

        $validateRoles = [];
        foreach ($roles as $r) {
            if (!$r instanceof Role) {
                throw new InvalidArgumentException(
                    "Each item in roles must be instance of Role, got: " . (is_object($r) ? get_class($r) : gettype($r))
                );
            }
            $validateRoles[] = $r;

        }

        if(0 === count($validateRoles)){
            $userRole = RoleFactory::create('user');
            $validateRoles[] = $userRole;
        }

        $user = new User($id, $email, $password, $validateRoles);
        $this->repo->save($user);

        return $user;
    }

    public function login(string $emailString, string $plainPassword): User
    {
        $email = new Email($emailString);
        $user = $this->repo->getByEmail($email);
        if ($user === null) {
            throw new InvalidArgumentException('Invalid credentials.');
        }

        if (!$user->getPassword()->verify($plainPassword)) {
            throw new InvalidArgumentException('Invalid credentials.');
        }

        $_SESSION[self::AUTH_KEY] = (string)$user->getId();

        return $user;
    }

    public function getCurrentUser(): ?User
    {
        if (empty($_SESSION[self::AUTH_KEY])) {
            return null;
        }
        $id = new Id($_SESSION[self::AUTH_KEY]);
        return $this->repo->getById($id);
    }

    public function logout(): void
    {
        unset($_SESSION[self::AUTH_KEY]);
    }

    private function generateFakeUuid(): string
    {
        $int = random_int(1000, 9999);

        return '550e8400-e29b-41d4-a716-44665544'. $int;

    }

}