<?php

namespace Database\Seeders;

use App\Models\Url;
use Illuminate\Database\Seeder;
use Tests\Feature\UrlShorteningApiTest;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $shortUrlData = UrlShorteningApiTest::provideShortUrlData();

        foreach ($shortUrlData['test_short_urls'] as $shortUrl) {
            Url::factory()->create([
                'short_url' => $shortUrl,
            ]);
        }
    }
}
