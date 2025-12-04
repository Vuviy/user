<?php

namespace App\Repository;

class BookRepository implements ItemRepositoryInterface
{

    public function insert(): string
    {
        return 'created book';
    }

    public function edit(): string
    {
        return 'edited book';

    }

    public function delete(): string
    {

        return 'deleted book';
    }

    public function get(): string
    {
        return 'get book';
    }
}