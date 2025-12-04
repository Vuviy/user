<?php

namespace App\Repository;

class CatalogRepository implements ItemRepositoryInterface
{
    public function insert(): string
    {
        return 'created catalog';
    }

    public function edit(): string
    {
        return 'edited catalog';

    }

    public function delete(): string
    {

        return 'deleted catalog';
    }

    public function get(): string
    {
        return 'get catalog';
    }
}