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
     * Encode and Store the Url endpoint.
     */
    public function store(UrlPostRequest $request): Response
    {
        $longUrl = $request->input('longUrl');
        $response = $this->urlShorteningService->saveUrl($longUrl);

        return response(new UrlResource($response), 201)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Decode and Show the Url endpoint.
     */
    public function show(Request $request): Response
    {
        $shortUrl = $request->shortUrl;

        $response = $this->urlShorteningService->retrieveUrl($shortUrl);
        return response(new UrlResource($response), 200)->header('Content-Type', 'application/json');
    }
}
