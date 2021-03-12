<?php


namespace App\Services;


use App\Models\Url;

interface ShortenerServiceInterface
{
    public function createShortener(string $originalUrl): Url;

    public function getOriginalLink(string $code): string;

    public function editShortener(int $urlId,string $code);
}
