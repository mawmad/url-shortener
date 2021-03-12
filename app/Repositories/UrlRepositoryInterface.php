<?php


namespace App\Repositories;


use App\Models\Url;

interface UrlRepositoryInterface
{
    public function findByCode(string $code): ?Url;

    public function save(Url $url): Url;

    public function find(int $id): ?Url;

}
