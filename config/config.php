<?php

use Framework\Router;
use Psr\Container\ContainerInterface;
use Framework\Renderer\RendererInterface;
use Framework\Router\RouterTwigExtension;
use Framework\Renderer\TwigRendererFactory;

    return  [
        'database.host' => 'localhost',
        'database.user' => 'root',
        'database.password' => '',
        'database.name' => 'abk_database',
        'views.path' => dirname(__DIR__) . '/views',
        'twig.extensions' => [
            \DI\get(\Framework\Router\RouterTwigExtension::class)
        ],
        Router::class => \DI\object(),
        RendererInterface::class => \DI\factory(TwigRendererFactory::class),
        \PDO::class => function(ContainerInterface $c) {
            return $pdo = new PDO(
                'mysql:host=' . $c->get('database.host'). 
                ';dbname=' . $c->get('database.name'),
                $c->get('database.user'),
                $c->get('database.password'), 
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );

        }
    ];
?>