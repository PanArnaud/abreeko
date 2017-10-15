<?php
namespace Tests\App\Blog\Actions;

use stdClass;
use Framework\Router;
use Prophecy\Argument;
use App\Blog\Table\PostTable;
use App\Blog\Actions\BlogAction;
use Framework\Renderer\RendererInterface;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;

class BlogActionTest extends TestCase
{
    /**
     * 
     * @var BlogAction
     */
    private $action;

    private $renderer;

    private $postTable;

    private $router;

    public function setUp() 
    {
        $this->renderer = $this->prophesize(RendererInterface::class);
        $this->router = $this->prophesize(Router::class);
        $this->postTable = $this->prophesize(PostTable::class);
        $this->action = new BlogAction(
            $this->renderer->reveal(),
            $this->router->reveal(),
            $this->postTable->reveal()
        );
    }
     
    public function makePost(int $id, string $slug): stdClass 
    {
        $post = new \stdClass();
        $post->id = $id;
        $post->slug = $slug;
        return $post;
    }

    public function testShowRedirect()
    {
        $post = $this->makePost(9, 'this-is-slug');
        $request = (new ServerRequest('GET', '/'))
            ->withAttribute('id', $post->id)
            ->withAttribute('slug', 'demo');

        $this->router->generateUri('blog.show', [
            'id' => $post->id, 
            'slug' => $post->slug
        ])->willReturn('/demo2');
        $this->postTable->find($post->id)->willReturn($post);
        
        $response = call_user_func_array($this->action, [$request]);
        $this->assertEquals(301, $response->getStatusCode());
        $this->assertEquals(['/demo2'], $response->getHeader('location'));
    }

    public function testShowRender()
    {
        $post = $this->makePost(9, 'this-is-slug');
        $request = (new ServerRequest('GET', '/'))
            ->withAttribute('id', $post->id)
            ->withAttribute('slug', $post->slug);
        $this->postTable->find($post->id)->willReturn($post);
        $this->renderer->render('@blog/show', ['post' => $post])->willReturn('');
        
        $response = call_user_func_array($this->action, [$request]);
        $this->assertEquals(true, true);
    }
}
