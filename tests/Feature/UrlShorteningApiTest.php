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
    public function test_encode_returns_a_201_successfully_created_url_response_resource($longUrl): void
    {

        // Arrange
        // Act
        $response = $this->postJson('/api/encode', ['longUrl' => $longUrl]);

        // Assert
        $response
            ->assertStatus(201)
            ->assertJson([
                'shortUrl' => true,
                'longUrl' => true
            ]);
    }

    /**
     * Test to check that the '/decode' endpoint returns a 200 status code 
     * with a json response object that has a required properties on it.
     */
    #[DataProvider("provideShortUrlData")]
    public function test_decode_returns_a_200_successful_response_resource($shortUrl): void
    {
        // Arrange
        $this->seed();

        // Act
        $response = $this->json('GET', '/api/decode', ['shortUrl' => $shortUrl]);

        // Assert
        $response
            ->assertStatus(200)
            ->assertJson([
                'shortUrl' => true,
                'longUrl' => true
            ]);
    }

    /**
     * Test to check that the '/decode' endpoint returns a 404 status code 
     * when the shortUrl Code does not match a resource in the database.
     */
    public function test_decode_returns_a_404_when_resource_is_not_found(): void
    {

        // Arrange
        $this->seed();

        // Act
        $response = $this->json('GET', '/api/decode', ['shortUrl' => 'http://short.est/RanD0m']);

        // Assert
        $response->assertStatus(404);
    }

    /**
     * Test to  that the '/encode' endpoint returns a 400 status code 
     * when no longUrl is provided
     */
    public function test_encode_returns_a_400_when_no_longUrl_is_provided(): void
    {

        // Arrange & Act
        $response = $this->postJson('/api/encode');

        // Assert
        $response->assertStatus(400);
    }

    /**
     * Test to  that the '/encode' endpoint returns a 400 status code 
     * when no longUrl is provided
     */
    #[DataProvider("provideInvalidUrlData")]
    public function test_encode_returns_a_400_when_invalidUrl_is_provided($invalidUrl): void
    {

        // Arrange & Act
        $response = $this->postJson('/api/encode', ["longUrl" => $invalidUrl]);

        // Assert
        $response->assertStatus(400);
    }

    /**
     * Test to  that the '/encode' endpoint returns a 400 status code 
     * when a URL over 2000 chars is provided
     */
    public function test_encode_returns_a_400_when_extremelyLongUrl_is_provided(): void
    {

        // Arrange
        $extremelyLongUrl = 'https://www.thisisalongdomain.com/with/some/parameters?and=here_too';
        for ($i = 1; $i < 200; $i++) {
            $extremelyLongUrl .= '&and=here_too';
        }

        // Act
        $response = $this->postJson('/api/encode', ["longUrl" => $extremelyLongUrl]);

        // Assert
        $response->assertStatus(400);
    }

    public static function provideLongUrlData()
    {
        return [
            'test_long_urls' => [
                'https://www.thisisalongdomain.com/with/some/parameters?and=here_too',
                'https://www.sdgghegeg.org/verylongdirectoryname?and=param',
                'http://blahbfh.co.uk/route/some/extra?and=here_too&more=bar',
                'http://www.google.com/whate/ersf/sdfdv?foo=bar',
            ],
        ];
    }

    public static function provideShortUrlData()
    {
        return [
            'test_short_urls' => [
                'http://short.est/ME6npw',
                'http://short.est/v8i2VA',
                'http://short.est/2HUdkA',
                'http://short.est/VSgSCw',
            ],
        ];
    }

    public static function provideInvalidUrlData()
    {
        return [
            'test_invalid_urls' => [
                'https:/www.thisisalongdomain.c/with/some/parameters?and=here_too',
                's://www.sdgghegeg.org/verylongdirectoryname?and=param',
                'blahbfh.co.uk/route/some/extra?and=here_too&more=bar',
                '123',
            ],
        ];
    }
}
