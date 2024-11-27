<?php 
namespace Controllers;

use \DI\Container;

class BaseController
{
    public $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }
}