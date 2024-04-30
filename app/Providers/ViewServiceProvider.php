<?php

declare(strict_types=1);

namespace App\Providers;

use System\Http\Response;
use System\Integrate\ServiceProvider;
use System\Integrate\Vite;
use System\View\Templator;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $global_template_var = [
            'vite_has_manifest' => file_exists($this->app->public_path() . '/build/manifest.json'),
        ];

        $this->app->set('view.instance', fn () => new Templator(view_path(), cache_path()));

        $this->app->set(
            'view.response',
            fn () => fn (string $view, array $data = []): Response =>
                (new Response())->setContent(
                    $this->app->make('view.instance')->render("{$view}.template.php", array_merge($data, $global_template_var))
                )
        );

        $this->app->set('vite.gets', fn () => new Vite($this->app->public_path(), '/build/'));
    }
}
