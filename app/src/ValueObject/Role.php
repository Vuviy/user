<?php

namespace App\ValueObject;

use InvalidArgumentException;

final class Role
{
    public const ADMIN = 'admin';
    public const MODERATOR = 'moderator';
    public const USER = 'user';

    /** @var string[] */
    private const ALLOWED = [
        self::ADMIN,
        self::MODERATOR,
        self::USER,
    ];

    /** @var string */
    private string $value;


    /**
     * Role constructor
     *
     * @param string $role
     * @throws InvalidArgumentException
     */
    public function __construct(string $role)
    {
        $role = strtolower(trim($role));

        if (!in_array($role, self::ALLOWED, true)) {
            throw new InvalidArgumentException("Invalid role: {$role}");
        }

        $this->value = $role;
    }

    public function is(string $role): bool
    {
        return $this->value === strtolower($role);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}