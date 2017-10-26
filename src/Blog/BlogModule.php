<?php
namespace App\Blog;

use Framework\Module;
use Framework\Router;
use App\Blog\Actions\BlogAction;
use App\Blog\Actions\AdminBlogAction;
use Psr\Container\ContainerInterface;
use Framework\Renderer\RendererInterface;

class BlogModule extends Module
{

    const DEFINITIONS = __DIR__.'/config.php';
    
    const MIGRATIONS = __DIR__.'/db/migrations';

    const SEEDS = __DIR__.'/db/seeds';

    public function __construct(ContainerInterface $container)
    {
        $container->get(RendererInterface::class)->addPath('blog', __DIR__.'/views');
        $router = $container->get(Router::class);
        $router->get($container->get('blog.prefix'), BlogAction::class, 'blog.index');
        $router->get($container->get('blog.prefix') . '/{slug:[a-z\-0-9]+}-{id:[0-9]+}', BlogAction::class, 'blog.show');
    
        if ($container->has('admin.prefix')) {
            $prefix = $container->get('admin.prefix');
            $router->crud("$prefix/posts", AdminBlogAction::class, 'blog.admin');
        }
    }
}
