<?php

class MyTwig extends \MyApp
{
    protected $twig;
    private $slim_container;

    public function __construct() {
        parent::__construct();

        $app                  = new \Slim\App();
        $this->slim_container = $app->getContainer();

        $loader = new \Twig\Loader\FilesystemLoader( APP_DIR . '/templates' );
        $this->twig = new \Twig\Environment($loader, [
            'cache'       => APP_DIR . '/cache',
            'auto_reload' => true,
            'autoescape'  => 'html'
        ]);

        $this->twigFunction();
    }

    public function twig()
    {
        return $this->twig;
    }

    public function addGlobal($key, $value)
    {
        // $this->twig();

        $this->twig->addGlobal($key, $value);
    }

    private function twigFunction()
    {
        $this->twig->addGlobal('base_url', $_ENV["APP_URL"]);

        $function = new \Twig\TwigFunction('function_name', function () {
            return "apa";
        });
        $this->twig->addFunction($function);

        $function = new \Twig\TwigFunction('alertError', function () {
            return $this->getAlert("error");
        });
        $this->twig->addFunction($function);

        $function = new \Twig\TwigFunction('alertWarning', function () {
            return $this->getAlert("warning");
        });
        $this->twig->addFunction($function);

        $function = new \Twig\TwigFunction('alertSuccess', function () {
            return $this->getAlert("success");
        });
        $this->twig->addFunction($function);

        $function = new \Twig\TwigFunction('alertInfo', function () {
            return $this->getAlert("info");
        });
        $this->twig->addFunction($function);

        $function = new \Twig\TwigFunction('session', function ($key) {
            $data = $this->session_->get($key);
            return (!empty($data)) ? $data : "";
        });
        $this->twig->addFunction($function);

        $function = new \Twig\TwigFunction('_hari', function ($harike) {
            $hari[1] = 'Senin';
            $hari[2] = 'Selasa';
            $hari[3] = 'Rabu';
            $hari[4] = 'Kamis';
            $hari[5] = 'Jum`at';
            $hari[6] = 'Sabtu';
            $hari[7] = 'Minggu';

            return $hari[ $harike ];
        });
        $this->twig->addFunction($function);

        $request = $this->slim_container->get('request');
        $uri = $request->getUri();
        $this->twig->addGlobal('uri_path', $uri->getPath());


        // $this->twig->addGlobal('alert_error',   $this->getAlert("error"));
        // $this->twig->addGlobal('alert_warning', $this->getAlert("warning"));
        // $this->twig->addGlobal('alert_success', $this->getAlert("success"));
        // $this->twig->addGlobal('alert_info',    $this->getAlert("info"));
    }
}
