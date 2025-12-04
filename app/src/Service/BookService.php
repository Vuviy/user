<?php

namespace App\Service;

use App\Repository\BookRepository;
use App\User;

class BookService implements ItemInterface
{
    public function __construct(public readonly BookRepository $bookRepository){}

    public function get(User $user): string
    {
        if($user->hasPermission('book.read')) {
            return $this->bookRepository->get();
        }
        return 'access denied';
    }

    public function create(User $user): string
    {
        if($user->hasPermission('book.create')) {
            return $this->bookRepository->insert();
        }
        return 'access denied';
    }

    public function delete(User $user): string
    {
          if($user->hasPermission('book.delete')) {
            return $this->bookRepository->insert();
        }
        return 'access denied';
    }

    public function edit(User $user): string
    {
           if($user->hasPermission('book.edit')) {
            return $this->bookRepository->insert();
        }
        return 'access denied';
    }
}