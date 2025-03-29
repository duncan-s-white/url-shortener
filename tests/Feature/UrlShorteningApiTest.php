<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrlShorteningApiTest extends TestCase
{
    /**
     * Test to check that the '/encode' endpoint returns a 201 status code 
     * with a response object that has a url property on it.
     */
    public function test_returns_a_successfully_created_response(): void
    {
        $response = $this->postJson('/api/encode', ['url' => 'https://www.thisisalongdomain.com/with/some/parameters?and=here_too']);

        $response
            ->assertStatus(201)
            ->assertJson([
                'url' => true
            ]);
    }
}
