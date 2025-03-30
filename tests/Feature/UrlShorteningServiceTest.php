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
}
