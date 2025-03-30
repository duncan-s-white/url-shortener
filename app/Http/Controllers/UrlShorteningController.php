<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlPostRequest;
use App\Http\Resources\UrlResource;
use App\Services\UrlShorteningService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UrlShorteningController extends Controller
{

    public function __construct(private UrlShorteningService $urlShorteningService) {}

    /**
     * Encode endpoint.
     */
    public function encode(UrlPostRequest $request): Response
    {
        $longUrl = $request->input('longUrl');

        $response = $this->urlShorteningService->saveUrl($longUrl);

        return response(new UrlResource($response), 201)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Decode endpoint.
     */
    public function decode(Request $request): Response
    {
        $shortUrl = $request->input('shortUrl');

        $response = $this->urlShorteningService->retrieveUrl($shortUrl);

        return response(new UrlResource($response), 201)
            ->header('Content-Type', 'application/json');
    }
}
