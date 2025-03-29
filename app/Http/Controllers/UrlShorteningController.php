<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UrlShorteningController extends Controller
{
    /**
     * Encode endpoint.
     */
    public function encode(Request $request): Response
    {
        $response = ["url" => $request->input('url')];

        return response($response, 201)->header('Content-Type', 'application/json');
    }
}
