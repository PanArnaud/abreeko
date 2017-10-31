<?php
namespace App\Blog\Actions;

use PDO;
use Framework\Router;
use GuzzleHttp\Psr7\Response;
use App\Blog\Table\PostTable;
use Framework\Session\FlashService;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

class AdminBlogAction
{

    private $renderer;
    private $postTable;
    private $router;
    private $flash;

    use RouterAwareAction;

    public function __construct(RendererInterface $renderer, Router $router, PostTable $postTable, FlashService $flash)
    {
        $this->renderer = $renderer;
        $this->postTable = $postTable;
        $this->router = $router;
        $this->flash = $flash;
    }

    public function __invoke(Request $request)
    {
        if ($request->getMethod() === 'DELETE') {
            return $this->delete($request);
        }
        if (substr((string)$request->getUri(), -3) === 'new') {
            return $this->create($request);
        }
        if ($request->getAttribute('id')) {
            return $this->edit($request);
        }
        return $this->index($request);
    }

    public function index(Request $request): string
    {
        $params = $request->getQueryParams();
        ;
        $items = $this->postTable->findPaginated(12, $params['p'] ?? 1);
        return $this->renderer->render('@blog/admin/index', compact('items'));
    }

    /**
     *
     * @param Request $request
     * @return Response|string
     */
    public function edit(Request $request)
    {
        $item = $this->postTable->find($request->getAttribute('id'));
        
        if ($request->getMethod() === 'POST') {
            $params = $this->getParams($request);
            $params['updated_at'] = date('Y-m-d H:i:s');
            $this->postTable->update($item->id, $params);
            $this->flash->success('The post has been successfully edited');
            return $this->redirect('blog.admin.index');
        }
        return $this->renderer->render('@blog/admin/edit', compact('item'));
    }

    /**
     * Create a new post
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            $params = $this->getParams($request);
            $params = array_merge($params, [
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $this->postTable->insert($params);
            $this->flash->success('The post has been successfully created');
            return $this->redirect('blog.admin.index');
        }
        return $this->renderer->render('@blog/admin/create', compact('item'));
    }

    public function delete(Request $request)
    {
        $this->postTable->delete($request->getAttribute('id'));
        return $this->redirect('blog.admin.index');
    }

    private function getParams(Request $request)
    {
        return array_filter($request->getParsedBody(), function ($key) {
            return in_array($key, ['name', 'slug', 'content']);
        }, ARRAY_FILTER_USE_KEY);
    }
}
