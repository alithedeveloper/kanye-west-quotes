<?php

namespace Tests\Feature;

use App\Services\Quotes\Manager;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RefreshQuotesTest extends TestCase
{
    #[test]
    public function it_should_refresh_quotes()
    {
        // Assume cache key for quotes is 'kanye-quotes'
        $cacheKey = 'kanye-quotes';
        $cachedData = [['quote' => 'Cached quote']];

        // Cache the quotes
        Cache::put($cacheKey, $cachedData, 60);

        // Check if cache is set
        $this->assertTrue(Cache::has($cacheKey));
        $this->assertEquals($cachedData, Cache::get($cacheKey));

        // Fake the API response
        Http::fake([
            'api.kanye.rest' => Http::response(['quote' => 'New fetched quote'], 200)
        ]);

        // Refresh the quotes
        $response = $this->get('/api/quotes/refresh', [
            'Authorization' => 'Bearer valid-token'
        ])
            ->assertOk()
            ->assertJsonStructure([
                'message',
                'data'
            ]);

        $this->assertEquals('Quotes cache has been refreshed.', $response['message']);
        $this->assertCount(5, $response['data']);
    }
}
