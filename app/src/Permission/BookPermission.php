<?php

namespace App\Permission;

use InvalidArgumentException;

final class BookPermission implements PermissionInterface
{

    public const READ   = 'book.read';
    public const CREATE = 'book.create';
    public const EDIT   = 'book.edit';
    public const DELETE = 'book.delete';

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