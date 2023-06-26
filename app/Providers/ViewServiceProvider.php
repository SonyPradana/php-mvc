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
        $resource_component = [
            'vite' => new Vite($this->app->public_path(), 'build/'),
        ];
        $this->app->set(
            'view.response',
            fn () => fn (string $view, array $data = []): Response => (new Response())
                ->setContent(
                    (new Templator(view_path(), cache_path()))
                        ->render("{$view}.template.php", array_merge($data, $resource_component))
                )
        );
        $this->app->set('vite.gets', fn () => new Vite($this->app->public_path(), 'build/'));
    }
}
