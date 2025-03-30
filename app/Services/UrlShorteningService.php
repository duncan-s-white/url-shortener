<?php

namespace App\Services;

use App\Models\Url;
use Illuminate\Support\Facades\DB;

class UrlShorteningService
{

    public const DOMAIN_NAME = 'http://short.est/';

    /**
     * Create a new UrlShorteningService instance.
     */
    public function __construct()
    {
        //
    }

    public function saveUrl($longUrl): Url
    {
        $url = Url::create([
            'long_url' => $longUrl,
            'short_url' => "",
        ]);

        $url->save();

        // Use Redis to create the Number for the encoded Url? 
        // Quicker no need to save twice
        $url->short_url = self::DOMAIN_NAME . $this->encodeUrl($url->id);

        $url->save();

        return $url;
    }

    protected function encodeUrl($number): string
    {
        // Improve the encode Url function returning 'xxAAAAA' currently
        return strtr(rtrim(base64_encode(pack('i', $number)), '='), '+/', '-_');
    }

    public function retrieveUrl($shortUrl)
    {
        $url = DB::table('urls')
            ->select('short_url', 'long_url', 'created_at')
            ->where('short_url', '=', $shortUrl)
            ->firstOrFail();

        return $url;
    }
}
