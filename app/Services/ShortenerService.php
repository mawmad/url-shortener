<?php


namespace App\Services;


use App\Models\Url;
use App\Repositories\UrlRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShortenerService implements ShortenerServiceInterface
{
    private $urlRepository;

    public function __construct(UrlRepositoryInterface $urlRepository)
    {

        $this->urlRepository = $urlRepository;
    }

    private function generateShortCode()
    {
        do {
            $code = Str::random(env('SHORT_LINK_LENGTH', 7));
        } while ($this->urlRepository->findByCode($code));
        return $code;
    }

    public function createShortener(string $originalUrl): Url
    {
        $url = new Url();
        $url->original_link = $originalUrl;
        $url->code = $this->generateShortCode();
        $this->urlRepository->save($url);
        return $url;
    }

    public function getOriginalLink(string $code): string
    {
        $url = $this->urlRepository->findByCode($code);
        if (!$url || $this->isExpired($url)) {
            throw new NotFoundHttpException();
        }
        return $url->original_link;
    }

    private function isExpired(Url $url): bool
    {
        $expirationTime = env('SHORT_LINK_EXPIRATION', '10000'); //second
        $expiredAt = Carbon::parse($url->updated_at)->addSeconds($expirationTime)->timestamp;
        $nowTime = Carbon::now()->timestamp;
        if ($nowTime > $expiredAt)
            return true;
        return false;
    }

    public function editShortener(int $urlId, string $code)
    {
        $url = $this->urlRepository->find($urlId);
        if (!$url) {
            throw new NotFoundHttpException();
        }
        $url->code = $code;
        $this->urlRepository->save($url);
        return $url;
    }
}
