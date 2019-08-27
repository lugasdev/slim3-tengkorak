<?php
use Psr\Container\ContainerInterface;

namespace Controllers;

class Controller extends \MyApp {

    protected $container;
    protected $twig;
    protected $default_diklat = 0;

    public function __construct() {
        parent::__construct();

        $this->twig = $this->twig();

        $this->default_diklat = $this->session_->get('default_diklat');
    }

    public function view($filename, $datas = array())
    {
        $src_mytwig = new \MyTwig();
        return $src_mytwig->twig()->render($filename, $datas);
    }

    public function twig()
    {
        $src_mytwig = new \MyTwig();
        return $src_mytwig->twig();
    }

}

