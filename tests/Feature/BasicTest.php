<?php

namespace Tests\Feature;

use Tests\TestCase;

final class BasicTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_see_welcome_page(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }
}
