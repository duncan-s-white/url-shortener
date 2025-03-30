<?php

namespace Tests\Feature;

use App\Models\Url;
use App\Services\UrlShorteningService;
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
     * Test that the saveUrl method returns a shortUrl with the domain
     */
    #[DataProviderExternal(UrlShorteningApiTest::class, "provideLongUrlData")]
    public function test_saveUrl_method_returns_short_url_with_expected_domain($longUrl): void
    {
        // Arrange
        $urlShorteningServiceUT = new UrlShorteningService();
        $expectedDomain = UrlShorteningService::DOMAIN_NAME;

        // Act
        $urlModel = $urlShorteningServiceUT->saveUrl($longUrl);

        // Assert
        $this->assertStringContainsString($expectedDomain, $urlModel->short_url);
    }

    /**
     * Test that the shortUrl returned from SaveUrl has no more than 7 characters added to the baseurl
     */
    #[DataProviderExternal(UrlShorteningApiTest::class, "provideLongUrlData")]
    public function test_saveUrl_method_returns_short_url_with_a_max_7_chars_added_to_baseurl($longUrl): void
    {
        // Arrange
        $urlShorteningServiceUT = new UrlShorteningService();
        $domain = UrlShorteningService::DOMAIN_NAME;
        $expectedMaxChars = 7;

        // Act
        $urlModel = $urlShorteningServiceUT->saveUrl($longUrl);
        $result = str_replace($domain, '', $urlModel->short_url);

        // Assert
        $this->assertLessThanOrEqual($expectedMaxChars, strlen($result));
    }
}
