<?php

namespace App\Repository;

use App\User;
use App\ValueObject\Email;
use App\ValueObject\Id;

interface UserRepositoryInterface
{
    /**
     * save user
     */
    public function save(User $user): void;

    /**
     * return user by email or null
     */
    public function getByEmail(Email $email): ?User;

    /**
     * return user id or null
     */
    public function getById(Id $id): ?User;

    /**
     * delete user
     */
    public function delete(Id $id): void;
}