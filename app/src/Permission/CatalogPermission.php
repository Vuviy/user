<?php

namespace App\Permission;

use InvalidArgumentException;

final class CatalogPermission implements PermissionInterface
{

    public const READ   = 'catalog.read';
    public const CREATE = 'catalog.create';
    public const EDIT   = 'catalog.edit';
    public const DELETE = 'catalog.delete';

    private string $key;

    public function __construct(string $key)
    {
        if (!in_array($key, [self::READ, self::CREATE, self::EDIT, self::DELETE], true)) {
            throw new InvalidArgumentException("Invalid permission: {$key}");
        }

        $this->key = $key;
    }

    public function key(): string
    {
        return $this->key;
    }
}