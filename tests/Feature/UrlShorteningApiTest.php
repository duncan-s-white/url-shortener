<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class UrlShorteningApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test to check that the '/encode' endpoint returns a 201 status code 
     * with a json response object that has a required properties on it.
     */
    #[DataProvider("provideLongUrlData")]
    public function test_encode_returns_a_successfully_created_url_response_resource($longUrl): void
    {

        $response = $this->postJson('/api/encode', ['longUrl' => $longUrl]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'shortUrl' => true,
                'longUrl' => true,
                'createdAt' => true,
            ]);
    }

    /**
     * Test to check that the '/decode' endpoint returns a 201 status code 
     * with a json response object that has a required properties on it.
     */
    #[DataProvider("provideShortUrlData")]
    public function test_decode_returns_a_successfully_created_url_response_resource($shortUrl): void
    {

        $response = $this->postJson('/api/encode', ['longUrl' => $shortUrl]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'shortUrl' => true,
                'longUrl' => true,
                'createdAt' => true,
            ]);
    }

    public static function provideLongUrlData()
    {
        return [
            'test long url 1' => [
                'https://www.thisisalongdomain.com/with/some/parameters?and=here_too',
            ],
            'test long url 2' => [
                'https://www.sdgghegeg.org/verylongdirectoryname?and=param',
            ],
            'test long url 3' => [
                'http://blahbfh.co.uk/route/some/extra?and=here_too&more=bar',
            ],
        ];
    }

    public static function provideShortUrlData()
    {
        return [
            'test short url 1' => [
                'http://short.est/xGt6h3',
            ],
            'test short url 2' => [
                'http://short.est/pF6Yh1',
            ],
            'test short url 3' => [
                'http://short.est/kJyMb6',
            ],
        ];
    }
}
