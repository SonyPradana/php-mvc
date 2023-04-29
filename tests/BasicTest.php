<?php

namespace System\Tests;

use PHPUnit\Framework\TestCase;

final class BasicTest extends TestCase
{
  /**
   * @test
   */
  public function it_true_is_true(): void
  {
    $this->assertTrue(true);
  }
}
