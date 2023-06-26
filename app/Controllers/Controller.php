<?php

namespace App\Controllers;

use System\Http\Response;
use System\Router\Controller as BaseController;
use System\View\Templator;

class Controller extends BaseController
{
    /**
     * @param array<string, mixed> $portal
     */
    public function view(string $view, array $portal = []): Response
    {
        $headers = $portal['headers'] ?? [];
        $status  = $portal['headers']['status'] ?? 200;
        $data    = array_filter($portal, fn ($key) => $key !== 'headers', ARRAY_FILTER_USE_KEY);
        $t       = new Templator(view_path(), cache_path());
        $render  = $t->render($view . '.template.php', $data);

        return new Response($render, $status, $headers);
    }

    public static function view_exists(string $view): bool
    {
        return file_exists(view_path() . $view . '.template.php');
    }
}
