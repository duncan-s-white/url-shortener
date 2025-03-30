<?php

namespace App\Services;

use App\Models\Url;

class UrlShorteningService
{

    public const DOMAIN_NAME = 'http://short.est/';

    public function saveUrl($longUrl): Url
    {
        $shortUrl = self::DOMAIN_NAME . $this->encodeUrl($longUrl);

        // Check if Url exists in the database already

        $url = Url::create([
            'long_url' => $longUrl,
            'short_url' => $shortUrl,
        ]);

        $url->save();

        return $url;
    }

    public function retrieveUrl($shortUrl): Url
    {
        $url = Url::select()
            ->where('short_url', '=', $shortUrl)
            ->firstOrFail();

        return $url;
    }

    protected function encodeUrl($longUrl): string
    {
        $md5Url = md5($longUrl);
        $first6bytesOfHash = bin2hex(substr(hex2bin($md5Url), 0, 6));
        $decimalStr = hexdec($first6bytesOfHash);
        return strtr(rtrim(base64_encode(pack('i', $decimalStr)), '='), '+/', '-_');
    }
}
