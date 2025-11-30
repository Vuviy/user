<?php

namespace App;

class Permission
{
    const string CREATE = 'create';
    const string READ = 'read';
    const string UPDATE = 'update';
    const string DELETE = 'delete';

    public static function getPermissions(User $user): array
    {

        $role = $user->getRole();

        if(in_array($role, ['admin'])){
            return [self::CREATE, self::READ, self::UPDATE, self::DELETE];
        }

        if(in_array($role, ['moderator'])){
            return [self::CREATE, self::READ, self::UPDATE];
        }

        if(in_array($role, ['user'])){
            return [self::READ];
        }

        return [self::READ];
    }

}