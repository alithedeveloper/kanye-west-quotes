<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class QuotesTest extends TestCase
{
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
            'api.kanye.rest' => Http::sequence()
                ->push(['quote' => 'I love Kanye'])
                ->push(['quote' => 'I hate giving interviews'])
                ->push(['quote' => 'I am a god'])
                ->push(['quote' => 'I am the number one human being in music'])
                ->push(['quote' => 'I am Shakespeare in the flesh'])
        ]);

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
}
