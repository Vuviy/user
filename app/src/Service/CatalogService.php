<?php

namespace App\Service;

use App\Repository\BookRepository;
use App\Repository\CatalogRepository;
use App\User;

class CatalogService implements ItemInterface
{
    public function __construct(public readonly CatalogRepository $catalogRepository){}

    public function get(User $user): string
    {
        if($user->hasPermission('catalog.read')) {
            return $this->catalogRepository->get();
        }
        return 'access denied';
    }

    public function create(User $user): string
    {
        if($user->hasPermission('catalog.create')) {
            return $this->catalogRepository->insert();
        }
        return 'access denied';
    }

    public function delete(User $user): string
    {
          if($user->hasPermission('catalog.delete')) {
            return $this->catalogRepository->insert();
        }
        return 'access denied';
    }

    public function edit(User $user): string
    {
           if($user->hasPermission('catalog.edit')) {
            return $this->catalogRepository->insert();
        }
        return 'access denied';
    }
}