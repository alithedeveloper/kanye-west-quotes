<?php

namespace Tests\Integration;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[group('integration')]
class QuotesTest extends TestCase
{
    #[Test]
    public function it_can_successfully_retrieve_list_of_quotes_from_api(): void
    {
        $this->get('/api/quotes', [
            'Authorization' => 'Bearer valid-token'
        ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ])
            ->assertJsonCount(5, 'data');
    }
}
