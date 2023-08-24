<?php

namespace App\Controllers;

use System\Http\Response;
use System\Router\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @param array<string, mixed> $portal
     */
    public static function renderView(string $view, array $portal = []): Response
    {
        return view($view, $portal);
    }

    public static function viewExists(string $view): bool
    {
        return file_exists(view_path() . $view . '.template.php');
    }
}
