<?php

namespace App\Services;

use App\Models\Url;

class UrlShorteningService
{

    public function saveUrl($longUrl): Url
    {
        $existingUrl = Url::where('long_url', '=', $longUrl)->first();

        if ($existingUrl) {
            return $existingUrl;
        }

        $shortUrl = config('urlshortener.domain') . $this->encodeUrl($longUrl);

        $newUrl = Url::create([
            'long_url' => $longUrl,
            'short_url' => $shortUrl,
        ]);

        return $newUrl;
    }

    public function retrieveUrl($shortUrl): Url
    {
        return Url::where('short_url', '=', $shortUrl)->firstOrFail();
    }

    protected function encodeUrl($longUrl): string
    {
        $md5Url = md5($longUrl);
        $first6bytesOfHash = bin2hex(substr(hex2bin($md5Url), 0, 6));
        $decimalStr = hexdec($first6bytesOfHash);
        $binaryStr = pack('i', $decimalStr);
        $encodedStr = rtrim(base64_encode($binaryStr), '=');
        $urlsafeEncodedStr = strtr($encodedStr, '+/', '-_');
        return $urlsafeEncodedStr;
    }
}
