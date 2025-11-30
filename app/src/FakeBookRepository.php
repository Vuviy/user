<?php

namespace App;

use App\Repository\SessionUserRepository;
use App\Service\AuthService;

class FakeBookRepository
{
    private ?User $authUser;
    private array $permissions;

    public function __construct()
    {
        $repo = new SessionUserRepository();
        $authServise = new AuthService($repo);
        $this->authUser = $authServise->getCurrentUser();
        $this->permissions = Permission::getPermissions($this->authUser);
    }

    public function fakeCreateBook()
    {

        if (in_array('create', $this->permissions)) {
            return 'created book';
        }
        return 'this user can not create book';
    }

    public function fakeEditBook()
    {
        if (in_array('update', $this->permissions)) {
            return 'edited book';
        }
        return 'this user can not edit book';

    }

    public function fakeDeleteBook()
    {
        if (in_array('delete', $this->permissions)) {
            return 'deleted book';
        }

        return 'this user can not delete book';
    }

    public function fakeGetBook()
    {
        return 'get book';
    }
}