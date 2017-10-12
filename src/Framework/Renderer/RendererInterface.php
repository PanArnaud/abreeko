<?php
namespace Framework\Renderer;

interface RendererInterface
{
  /**
   * Allow to add paths to load views
   * @param string $namespace
   * @param [type] $path
   */
    public function addPath(string $namespace, ?string $path = null): void;

  /**
   * Allow to render a view
   * Path can be set with namespace added by AddPath
   * $this->render('@blog/view');
   * $this->render('view');
   * @param  string $view
   * @param  array  $params
   * @return string
   */
    public function render(string $view, array $params = []): string;

  /**
   * Allow to add global variables to all views
   * @param string $key
   * @param mixed $value
   */
    public function addGlobal(string $key, $value): void;
}
