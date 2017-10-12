<?php

use Framework\Router;
use Framework\Renderer\RendererInterface;
use Framework\Router\RouterTwigExtension;
use Framework\Renderer\TwigRendererFactory;

    return  [
        'views.path' => dirname(__DIR__) . '/views',
        'twig.extensions' => [
            \DI\get(\Framework\Router\RouterTwigExtension::class)
        ],
        Router::class => \DI\object(),
        RendererInterface::class => \DI\factory(TwigRendererFactory::class)
    ];
?>