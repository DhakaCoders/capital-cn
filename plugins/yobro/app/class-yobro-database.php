<?php


namespace YoBro\App;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class YoBro_Database{
  public $capsule;
  public function __construct(){
    $this->capsule = new Capsule;
    $this->init_config();
  }

  public function init_config(){
    global $wpdb;
    $this->capsule->addConnection(array(
      'driver'    => 'mysql',
      'host'      => DB_HOST,
      'port'      => null,
      'database'  => DB_NAME,
      'username'  => DB_USER,
      'password'  => DB_PASSWORD,
      'prefix'    => $wpdb->prefix,
      'charset'   => 'utf8',
      'collation' => 'utf8_general_ci'
    ));
    $this->capsule->setEventDispatcher(new Dispatcher(new Container));
    $this->capsule->setAsGlobal();
    $this->capsule->bootEloquent();
    date_default_timezone_set('UTC');
  }
}
