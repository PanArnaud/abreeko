<?php
namespace Tests\Framework;

use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{

    /**
     * @var Router
     */
    private $router;

    public function setUp()
    {
        $this->router = new Router();
    }

    // Delete getTest

    public function testGenerateURI()
    {
        $this->router->get('/blog', function () { return 'azeazea'; }, 'posts');
        $this->router->get('/blog/{slug:[a-z-0-9\-]+}-{id:\d+}', function() { 'hello'; }, 'post.show');
        $uri = $this->router->generateUri('post.show', ['slug' => 'mon-article', 'id' => 18]);
        $this->assertEquals('/blog/mon-article-18', $uri);
    }

    public function testGenerateURIWithQueryParams()
    {
        $this->router->get('/blog', function () { return 'azeazea'; }, 'posts');
        $this->router->get('/blog/{slug:[a-z-0-9\-]+}-{id:\d+}', function() { 'hello'; }, 'post.show');
        $uri = $this->router->generateUri(
            'post.show', 
            ['slug' => 'mon-article', 'id' => 18],
            ['p' => 2]
        );
        $this->assertEquals('/blog/mon-article-18?p=2', $uri);
    }
}
