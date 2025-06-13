<?php

use App\Middlewares\AppMiddleware;
use System\Http\JsonResponse;
use System\Router\Attribute\Middleware;
use System\Router\Attribute\Name;
use System\Router\Attribute\Prefix;
use System\Router\Attribute\Route\Get;

#[Prefix('/api/v1')]
#[Middleware([AppMiddleware::class])]
final class IndexService
{
    #[Name('api.v1.index')]
    #[Get('/index')]
    public function index(): JsonResponse
    {
        return new JsonResponse([
            'say' => 'hello',
        ]);
    }
}
