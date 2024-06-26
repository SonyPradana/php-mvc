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
        $this->registerViteResolver();
        $this->registerViewResolver();
    }

    protected function registerViteResolver(): void
    {
        $this->app->set('vite.gets', fn (): Vite => new Vite($this->app->publicPath(), '/build/'));
        $this->app->set('vite.location', fn (): string => $this->app->publicPath() . '/build/manifest.json');
        $this->app->set('vite.hasManifest', fn (): bool => file_exists($this->app->get('vite.location')));
    }

    protected function registerViewResolver(): void
    {
        $global_template_var = [
            'vite_has_manifest' => $this->app->get('vite.hasManifest'),
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
    }
}
