<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class QuotesTest extends TestCase
{
    private string $quotesApiUrl;

    protected function setUp(): void
    {
        parent::setUp();
        $this->quotesApiUrl = 'https://api.kanye.rest';
        Config::set('kanye.cache.enabled', false);
    }

    #[Test]
    public function it_returns_error_if_no_token_is_supplied(): void
    {
        $this->get('/api/quotes')
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonStructure([
                'message',
                'data'
            ])
            ->assertJson([
                'data' => null,
                'message' => 'Unauthorized'
            ]);
    }

    #[Test]
    public function it_returns_error_if_invalid_token_is_supplied(): void
    {
        $this->get('/api/quotes', [
            'Authorization' => 'Bearer invalid-token'
        ])
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonStructure([
                'message',
                'data'
            ])
            ->assertJson([
                'data' => null,
                'message' => 'Unauthorized'
            ]);
    }

    #[Test]
    public function it_can_successfully_retrieve_list_of_quotes_from_api(): void
    {
        Http::fake([
            $this->quotesApiUrl => Http::sequence()
                ->push(['quote' => 'I love Kanye'])
                ->push(['quote' => 'I hate giving interviews'])
                ->push(['quote' => 'I am a god'])
                ->push(['quote' => 'I am the number one human being in music'])
                ->push(['quote' => 'I am Shakespeare in the flesh'])
        ]);

        Cache::shouldReceive('remember')
            ->never();

        $this->get('/api/quotes', [
            'Authorization' => 'Bearer valid-token'
        ])->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data'
            ])
            ->assertJson([
                'message' => 'OK'
            ])
            ->assertJsonCount(5, 'data');
    }


    #[Test]
    public function it_will_retrieve_quotes_from_cache_successfully_if_caching_is_enabled(): void
    {
        Config::set('kanye.cache.enabled', true);

        $cached_quotes = [
            ['quote' => 'Cached Test Kanye Quote 1'],
            ['quote' => 'Cached Test Kanye Quote 2'],
            ['quote' => 'Cached Test Kanye Quote 3'],
            ['quote' => 'Cached Test Kanye Quote 4'],
            ['quote' => 'Cached Test Kanye Quote 5']
        ];

        Http::fake([
            $this->quotesApiUrl => Http::response([
                ['quote' => 'Test Kanye Quote 1'],
                ['quote' => 'Test Kanye Quote 2'],
                ['quote' => 'Test Kanye Quote 3'],
                ['quote' => 'Test Kanye Quote 4'],
                ['quote' => 'Test Kanye Quote 5']
            ])
        ]);


        Cache::shouldReceive('remember')
            ->once()
            ->with('kanye_quotes', 60, \Mockery::type('callable'))
            ->andReturn($cached_quotes);

        $response = $this->get('/api/quotes', [
            'Authorization' => 'Bearer valid-token'
        ])->assertOk()
            ->assertJsonStructure([
                'message',
                'data'
            ]);

        $this->assertSame($response->json('data'), $cached_quotes);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Config::set('kanye.cache.enabled', false);
    }
}
