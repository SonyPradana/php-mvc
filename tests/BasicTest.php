<?php

namespace System\Tests;

use PHPUnit\Framework\TestCase;

final class BasicTest extends TestCase
{
  /**
   * @test
   */
  public function FrameworkStrucktur(): void
  {
    $this->assertFileExists('./bootstrap/init.php');

    $this->assertFileExists('./app/core/Config.php');
    $this->assertFileExists('./bootstrap/autoload.php');

    $this->assertFileExists('./app/core/CLI.php');
    $this->assertFileExists('./app/core/Config.php');
    $this->assertFileExists('./app/core/Controller.php');
    $this->assertFileExists('./app/core/GlobalFuntion.php');
    $this->assertFileExists('./app/core/Service.php');

    $this->assertFileExists('./app/core/template/command');
    $this->assertFileExists('./app/core/template/controller');
    $this->assertFileExists('./app/core/template/model');
    $this->assertFileExists('./app/core/template/service');
    $this->assertFileExists('./app/core/template/view');

    $this->assertFileExists('./public/index.php');

    $this->assertFileExists('./.env.example');
    $this->assertFileExists('./CHANGELOG.md');
    $this->assertFileExists('./cli');
    $this->assertFileExists('./composer.json');
    $this->assertFileExists('./package.json');
    $this->assertFileExists('./webpack.mix.js');
  }

  /**
   * @test
   */
  public function AssetStrucktur(): void
  {
    // css
    $this->assertFileExists('./resources/css/');

    // scss
    $this->assertFileExists('./resources/sass/');

    // js
    $this->assertFileExists('./resources/js/');
  }
}
