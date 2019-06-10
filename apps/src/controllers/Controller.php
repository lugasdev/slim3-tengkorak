<?php
use Psr\Container\ContainerInterface;

namespace Controllers;

class Controller  {

    protected $container;
    protected $twig;

    // constructor receives container instance
    // public function __construct(ContainerInterface $container) {
    //     $this->container = $container;
    // }
    public function __construct() {
        $this->twig = $this->twig();
    }

    public function view($filename)
    {
        return $this->twig()->render($filename);
    }

    public function twig()
    {
        $loader = new \Twig\Loader\FilesystemLoader( APP_DIR . '/templates' );
        $twig   = new \Twig\Environment($loader, [
            'cache' => APP_DIR . '/cache',
        ]);

        return $twig;
    }

}

