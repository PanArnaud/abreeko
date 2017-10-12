<?php
namespace App\Blog;

use Framework\Module;
use Framework\Router;
use App\Blog\Actions\BlogAction;
use Framework\Renderer\RendererInterface;

class BlogModule extends Module
{

    const DEFINITIONS = __DIR__.'/config.php';

    public function __construct(string $prefix, Router $router, RendererInterface $renderer)
    {
        $renderer->addPath('blog', __DIR__.'/views');
        $router->get($prefix, BlogAction::class, 'blog.index');
        $router->get($prefix . '/{slug:[a-z\-0-9]+}', BlogAction::class, 'blog.show');
    }
}
