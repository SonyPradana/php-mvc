<?php

namespace Application\Http;

use System\Router\Controller as BaseController;
use System\View\View;

class Controller extends BaseController
{
    public function __invoke($invoke)
    {
        call_user_func([$this, $invoke]);
    }

    public function view(string $view, array $portal = [])
    {
        $view_path = view_path($view . '.template.php');

        return View::render($view_path, $portal);
    }

    public static function view_exists($view): bool
    {
        return file_exists(view_path() . $view . '.template.php');
    }

    /**
     * Shorthand to create new controller.
     *
     * @param string $controller Name of contorller
     * @param array  $args       Paramter to pass controller contractor
     *
     * @return static Controller
     */
    public static function getController($contoller, $method, $args = [])
    {
        $contoller_location = controllers_path() . $contoller . '.php';
        if (file_exists($contoller_location)) {
            require_once $contoller_location;
            $controller_name = new $contoller();
            if (method_exists($controller_name, $method)) {
                call_user_func_array([$controller_name, $method], $args);

                return;
            }
        }
    }

    /**
     * @var static This classs
     */
    private self $_static;

    /**
     * Instance of controller.
     * Shorthadn to crete new class.
     */
    public static function static()
    {
        return self::$_static ?? new static();
    }
}
