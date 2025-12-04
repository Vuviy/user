<?php

namespace App\ValueObject;

use App\Permission;
use App\Permission\PermissionInterface;
use InvalidArgumentException;

final class Role
{
    public const ADMIN = 'admin';
    public const SUPER_ADMIN = 'super_admin';
    public const MODERATOR = 'moderator';
    public const USER = 'user';

    /** @var string[] */
    private const ALLOWED = [
        self::ADMIN,
        self::SUPER_ADMIN,
        self::MODERATOR,
        self::USER,
    ];

    /** @var string */
    private string $value;

    /** @var Permission[] */
    private array $permissions;

    /** @var Role[] */
    private array $roles = [];


    /**
     * Role constructor
     *
     * @param string $role
     * @throws InvalidArgumentException
     */
    public function __construct(string $role, array $permissions  = [], array $roles = [])
    {
        $role = strtolower(trim($role));

        if (!in_array($role, self::ALLOWED, true)) {
            throw new InvalidArgumentException("Invalid role: {$role}");
        }

        $this->value = $role;

        foreach ($permissions as $permission) {
            if (!$permission instanceof PermissionInterface) {
                throw new InvalidArgumentException(
                    "Each item in roles must be instance of Role, got: " . (is_object($permission) ? get_class($permission) : gettype($permission))
                );
            }
            $this->permissions[] = $permission;

        }

        foreach ($roles as $r) {
            if (!$r instanceof Role) {
                throw new InvalidArgumentException(
                    "Each item in roles must be instance of Role, got: " . (is_object($r) ? get_class($r) : gettype($r))
                );
            }
            $this->roles[] = $r;

        }


    }

    public function is(string $role): bool
    {
        return $this->value === strtolower($role);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function allPermissions(): array
    {
        $all = [];

        foreach ($this->permissions as $p) {
            $all[$p->key()] = $p;
        }

        foreach ($this->roles as $role) {
            foreach ($role->allPermissions() as $p) {
                $all[$p->key()] = $p;
            }
        }

        return array_values($all);
    }

    public function expand(): array
    {
        $result = [$this];

        foreach ($this->roles as $role) {
            $result = array_merge($result, $role->expand());
        }

        return $result;
    }
}