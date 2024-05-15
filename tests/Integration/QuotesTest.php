<?php

namespace Tests\Integration;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class QuotesTest extends TestCase
{

    #[Test]
    public function it_can_successfully_retrieve_list_of_quotes(): void
    {
        $this->get('/api/quotes')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ])
            ->assertJsonCount(5, 'data');
    }
}
