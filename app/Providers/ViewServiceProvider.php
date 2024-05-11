<?php

declare(strict_types=1);

namespace App\Providers;

use System\Http\Response;
use System\Integrate\ServiceProvider;
use System\Integrate\Vite;
use System\View\Templator;
use System\View\TemplatorFinder;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $global_template_var = [
            'vite_has_manifest' => file_exists($this->app->public_path() . '/build/manifest.json'),
        ];
        $extensions = $this->app->get('config')['VIEW_EXTENSIONS'] ?? [];

        $this->app->set(TemplatorFinder::class, fn () => new TemplatorFinder(view_paths(), $extensions));
        $this->app->set('view.instance', fn () => new Templator($this->app->get(TemplatorFinder::class), compiled_view_path()));
        $this->app->set(
            'view.response',
            fn () => fn (string $view, array $data = []): Response => new Response(
                $this->app->get('view.instance')->render($view, array_merge($data, $global_template_var))
            )
        );
        $this->app->set('vite.gets', fn () => new Vite($this->app->public_path(), '/build/'));
    }
}
