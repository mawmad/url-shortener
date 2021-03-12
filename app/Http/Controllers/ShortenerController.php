<?php


namespace App\Http\Controllers;


use App\Services\ShortenerServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShortenerController extends Controller
{
    private $shortenerService;

    public function __construct(ShortenerServiceInterface $shortenerService)
    {
        $this->shortenerService = $shortenerService;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|string|url'
        ]);
        $url = $this->shortenerService->createShortener($request->url);
        return response()->json([
            'shortLink' => url($url->code),
            'urlId' => $url->id
        ]);
    }

    public function redirect(string $code)
    {
        try {
            $originalLink = $this->shortenerService->getOriginalLink($code);
        } catch (Exception $exception) {
            $originalLink = "/";
        }
        return redirect($originalLink);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make([
            'id' => $id,
            'code' => $request->code
        ], [
            'id' => 'exists:urls,id',
            'code' => 'required|string|unique:urls,code'
        ]);
        if ($validator->fails())
            return response()->json($validator->errors(), 422);
        $url = $this->shortenerService->editShortener($id, $request->code);
        return response()->json([
            'shortLink' => url($url->code),
            'urlId' => $url->id
        ]);
    }
}
