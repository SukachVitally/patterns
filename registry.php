<?php
/*
 * ????
 */

class Registry {
    private static $instance;
    private $values = array();
    private function __construct() {

    }

    static function instance() {
        if( ! isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    function get($key) {
        if(isset($this->values[$key])) {
            return $this->values[$key];
        }
        return null;
    }

    function set($key, $value) {
        $this->values[$key] = $value;
    }

    function treeBuilder() {
        if( ! isset($this->treeBuilder())) {
            $this->treeBuilder = new TreeBuilder(
                $this->conf()->get('treedir')
            );
        }
        return $this->treeBuilder;
    }

    function conf() {
        if( ! iddet($this->conf)) {
            $this->conf = new Conf();
        }
        return $this->conf;
    }
}


class TreeBuilder {}

class Conf {}

$reg = Registry::instance();
