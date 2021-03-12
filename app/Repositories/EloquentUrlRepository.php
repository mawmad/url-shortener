<?php


namespace App\Repositories;


use App\Models\Url;

class EloquentUrlRepository implements UrlRepositoryInterface
{

    public function findByCode(string $code): ?Url
    {
        return Url::where('code', $code)->first();
    }

    public function save(Url $url): Url
    {
        $url->save();
        return $url;
    }

    public function find(int $id): ?Url
    {
        return Url::find($id);
    }

}
