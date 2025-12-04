<?php

namespace App\Repository;

interface ItemRepositoryInterface
{

    public function insert(): string;
    public function edit(): string;
    public function delete(): string;
    public function get(): string;

}