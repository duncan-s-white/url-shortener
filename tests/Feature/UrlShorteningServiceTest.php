<?php

namespace Tests\Feature;

use App\Models\Url;
use App\Services\UrlShorteningService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\TestCase;

class UrlShorteningServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the saveUrl method returns a Url Model
     */
    #[DataProviderExternal(UrlShorteningApiTest::class, "provideLongUrlData")]
    public function test_saveUrl_method_returns_a_Url_Model($longUrl): void
    {
        // Arrange
        $urlShorteningServiceUT = new UrlShorteningService();

        // Act
        $urlModel = $urlShorteningServiceUT->saveUrl($longUrl);

        // Assert
        $this->assertInstanceOf(Url::class, $urlModel);
    }

    /**
     * Test that the saveUrl method returns a shortUrl with the expected domain
     */
    #[DataProviderExternal(UrlShorteningApiTest::class, "provideLongUrlData")]
    public function test_saveUrl_method_returns_short_url_with_expected_domain($longUrl): void
    {
        // Arrange
        $urlShorteningServiceUT = new UrlShorteningService();
        $expectedDomain = config('urlshortener.domain');

        // Act
        $urlModel = $urlShorteningServiceUT->saveUrl($longUrl);

        // Assert
        $this->assertStringContainsString($expectedDomain, $urlModel->short_url);
    }

    /**
     * Test that the shortUrl returned from SaveUrl has no more than 6 characters added to the baseurl
     */
    #[DataProviderExternal(UrlShorteningApiTest::class, "provideLongUrlData")]
    public function test_saveUrl_method_returns_short_url_with_a_max_6_chars_added_to_baseurl($longUrl): void
    {
        // Arrange
        $urlShorteningServiceUT = new UrlShorteningService();
        $domain = config('urlshortener.domain');
        $expectedMaxChars = 6;

        // Act
        $urlModel = $urlShorteningServiceUT->saveUrl($longUrl);
        $result = str_replace($domain, '', $urlModel->short_url);

        // Assert
        $this->assertLessThanOrEqual($expectedMaxChars, strlen($result));
    }

    /**
     * Test that a record is added to the database when a new shortUrl is added
     */
    #[DataProviderExternal(UrlShorteningApiTest::class, "provideLongUrlData")]
    public function test_saveUrl_method_saves_a_record_to_the_database_when_a_new_short_url_is_added($longUrl): void
    {
        // Arrange
        $urlShorteningServiceUT = new UrlShorteningService();

        // Act
        $urlModel = $urlShorteningServiceUT->saveUrl($longUrl);

        // Assert
        $this->assertDatabaseCount('urls', 1);
    }

    /**
     * Test that the retrieveUrl method returns Url Model if a database record exists
     */
    #[DataProviderExternal(UrlShorteningApiTest::class, "provideShortUrlData")]
    public function test_retrieveUrl_method_returns_Url_Model_if_record_exists($shortUrl): void
    {
        $this->seed();

        // Arrange
        $urlShorteningServiceUT = new UrlShorteningService();

        // Act
        $urlModel = $urlShorteningServiceUT->retrieveUrl($shortUrl);

        // Assert
        $this->assertEquals($shortUrl, $urlModel->short_url);
    }

    /**
     * Test that retrieveUrl method throws a ModelNotFoundException if the record does not exist in the db
     */
    #[DataProviderExternal(UrlShorteningApiTest::class, "provideShortUrlData")]
    public function test_retrieveUrl_method_throws_exception_if_record_does_not_exists($shortUrl): void
    {

        // Arrange
        $urlShorteningServiceUT = new UrlShorteningService();

        // Act
        // Assert
        $this->assertThrows(fn() => $urlShorteningServiceUT->retrieveUrl($shortUrl), ModelNotFoundException::class);
    }
}
