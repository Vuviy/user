<?php

namespace App\Permission;

use InvalidArgumentException;

final class GodPermission implements PermissionInterface
{

    public const ALL   = 'god.all';

    private string $key;

    public function __construct(string $key)
    {
        if (!in_array($key, [self::ALL], true)) {
            throw new InvalidArgumentException("Invalid permission: {$key}");
        }

        $this->key = $key;
    }

    public function key(): string
    {
        return $this->key;
    }
}