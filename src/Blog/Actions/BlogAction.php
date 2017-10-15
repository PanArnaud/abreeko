<?php
namespace App\Blog\Actions;

use PDO;
use Framework\Router;
use GuzzleHttp\Psr7\Response;
use App\Blog\Table\PostTable;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogAction
{

    private $renderer;
    private $postTable;
    private $router;

    use RouterAwareAction;

    public function __construct(RendererInterface $renderer, Router $router, PostTable $postTable)
    {
        $this->renderer = $renderer;
        $this->postTable = $postTable;
        $this->router = $router;
    }

    public function __invoke(Request $request)
    {
        if ($request->getAttribute('id')) {
            return $this->show($request);
        }
        return $this->index();
    }

    public function index(): string
    {
        $posts = $this->postTable->findPaginated();
        return $this->renderer->render('@blog/index', compact('posts'));
    }

    /**
     * Display a post
     *
     * @param Request $request
     * @return ResponseInterface|string
     */
    public function show(Request $request)
    {
        $slug = $request->getAttribute('slug');
        $post = $this->postTable->find($request->getAttribute('id'));
        if ($post->slug !== $slug) {
            return $this->redirect('blog.show', [
               'slug' => $post->slug,
               'id' => $post->id
            ]);
        }
        return $this->renderer->render('@blog/show', [
          'post' => $post
        ]);
    }
}
