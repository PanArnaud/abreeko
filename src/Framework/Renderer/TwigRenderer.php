<?php
namespace Framework\Renderer;

class TwigRenderer implements RendererInterface
{

    private $twig;

    private $loader;

    public function __construct(\Twig_Loader_Filesystem $loader, \Twig_Environment $twig)
    {
        $this->loader = $loader;
        $this->twig = $twig;
    }

  /**
   * Allow to add paths to load views
   * @param string $namespace
   * @param [type] $path
   */
    public function addPath(string $namespace, ?string $path = null): void
    {
        $this->loader->addPath($path, $namespace);
    }

  /**
   * Allow to render a view
   * Path can be set with namespace added by AddPath
   * $this->render('@blog/view');
   * $this->render('view');
   * @param  string $view
   * @param  array  $params
   * @return string
   */
    public function render(string $view, array $params = []): string
    {
        return $this->twig->render($view . '.twig', $params);
    }

  /**
   * Allow to add global variables to all views
   * @param string $key
   * @param mixed $value
   */
    public function addGlobal(string $key, $value): void
    {
        $this->twig->addGlobal($key, $value);
    }
}
