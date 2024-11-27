<?php
namespace Services;

use \DI\Container;

class BaseObject
{
    public $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }
}