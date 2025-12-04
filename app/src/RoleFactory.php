<?php

namespace App;

use App\Permission\BookPermission;
use App\Permission\CatalogPermission;
use App\Permission\GodPermission;
use App\ValueObject\Role;
use InvalidArgumentException;

class RoleFactory
{
    public static function create(string $roleName): Role
    {
        return match ($roleName) {

            'super_admin' => new Role('super_admin',
                [
                    new GodPermission(GodPermission::ALL),
                ],
                [self::create('admin')]),
            'user' => new Role('user',
                [
                    new BookPermission(BookPermission::READ),
                    new CatalogPermission(CatalogPermission::READ)
                ]),
            'moderator' => new Role('moderator',
                [
                    new BookPermission(BookPermission::CREATE),
                    new BookPermission(BookPermission::EDIT),
                    new CatalogPermission(CatalogPermission::CREATE),
                    new CatalogPermission(CatalogPermission::EDIT),
                ],
                [self::create('user')]),
            'admin' => new Role('admin',
                [
                    new BookPermission(BookPermission::DELETE),
                    new CatalogPermission(CatalogPermission::DELETE),
                ],
                [self::create('moderator')]),
            default => throw new InvalidArgumentException("Unknown role: $roleName"),
        };
    }

}