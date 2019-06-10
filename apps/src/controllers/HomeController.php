<?php
use Psr\Container\ContainerInterface;

namespace Controllers;

class HomeController extends Controller
{
   // constructor receives container instance
   public function __construct() {
       parent::__construct();
   }

   public function home($req, $res, $args) {
        // your code
        // to access items in the container... $this->container->get('');
        return $this->view("cek.twig");
   }

   public function contact($req, $res, $args) {
        // your code
        // to access items in the container... $this->container->get('');
        return $res;
   }
}
