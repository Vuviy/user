<?php

namespace App\Service;

use App\User;

interface ItemInterface
{
    public function get(User $user): string;
    public function create(User $user): string;
    public function delete(User $user): string;
    public function edit(User $user): string;

}