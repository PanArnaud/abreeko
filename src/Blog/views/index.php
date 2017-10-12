<?= $renderer->render('header') ?>
  <h1>Bievenue sur le blog</h1>

  <ul>
    <li><a href="<?= $router->generateUri('blog.show', ['slug' => 'this-is-my-1st-post']) ?>">Article 1</a></li>
    <li><a href="<?= $router->generateUri('blog.show', ['slug' => 'this-is-my-2nd-post']) ?>">Article 2</a></li>
    <li><a href="<?= $router->generateUri('blog.show', ['slug' => 'this-is-my-3th-post']) ?>">Article 3</a></li>
  </ul>
<?= $renderer->render('footer') ?>
