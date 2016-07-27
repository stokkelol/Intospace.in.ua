<?php

namespace App\Traits;

trait InstanceTrait {

  public static function getInstance() {
    $class = get_called_class();
    if (static::$instance === NULL) {
        static::$instance = new $class();
    }

    return static::$instance;
  }
}
