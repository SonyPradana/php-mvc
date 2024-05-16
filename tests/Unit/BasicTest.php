<?php

namespace Tests\Unit;

use Tests\TestCase;

final class BasicTest extends TestCase
{
    /**
     * @test
     */
    public function assert_true_is_true(): void
    {
        $this->assertTrue(true);
    }
}
