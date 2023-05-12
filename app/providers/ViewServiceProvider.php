<?php

declare(strict_types=1);

namespace App\Providers;

use System\Http\Response;
use System\Integrate\ServiceProvider;
use System\View\Templator;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->set(
            'view.response',
            fn () => fn (string $view, array $data = []): Response => (new Response())
                ->setContent(
                    (new Templator(view_path(), cache_path()))
                        ->render("{$view}.template.php", $data)
                )
        );
    }
}
