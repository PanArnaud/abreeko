<?php
namespace Tests\App\Blog\Table;

use App\Blog\Entity\Post;
use Tests\DatabaseTestCase;
use App\Blog\Table\PostTable;

class PostTableTest extends DatabaseTestCase
{

    /**
     * @var PostTable
     */
    private $postTable;

    public function setUp() 
    {
        parent::setUp();
        $this->postTable = new PostTable($this->pdo);
    }

    public function testFind() 
    {
        $this->seedDatabase();
        $post = $this->postTable->find(1);
        $this->assertInstanceOf(Post::class, $post);
    }

    public function testFindNotFoundRecord() 
    {
        $post = $this->postTable->find(1);
        $this->assertNull($post);
    }

    public function testUpdate()
    {
        $this->seedDatabase();
        $this->postTable->update(1, ['name' => '1st update', 'slug' => '1st-update']);
        $post = $this->postTable->find(1);
        $this->assertEquals('1st update', $post->name);
        $this->assertEquals('1st-update', $post->slug);
    }

    public function testInsert() 
    {
        $this->postTable->insert(['name' => 'Hello', 'slug' => 'demo']);
        $post = $this->postTable->find(1);
        $this->assertEquals('Hello', $post->name);
        $this->assertEquals('demo', $post->slug);
    }

    public function testDelete()
    {
        $this->postTable->insert(['name' => 'Hello', 'slug' => 'demo']);
        $this->postTable->insert(['name' => 'Hello2', 'slug' => 'demo']);
        $count = $this->pdo->query('SELECT COUNT(id) FROM posts')->fetchColumn();
        $this->assertEquals(2, (int) $count);
        $this->postTable->delete($this->pdo->lastInsertId());
        $count = $this->pdo->query('SELECT COUNT(id) FROM posts')->fetchColumn();
        $this->assertEquals(1, (int) $count);
    }
}