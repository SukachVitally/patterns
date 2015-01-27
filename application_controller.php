<?php



class woo_controller_Controller {
    private $applicationHelper;

    private function __construct() {
    }

    static function run() {
        $instance = new woo_controller_Controller();
        $instance->init();
        $instance->handlerRequest();
    }
// Получает конфигурацию для всего приложения
    function init() {
        $applicationHelper = woo_controller_ApplicationHelper::instance();
        $applicationHelper->init();
    }

    function handlerRequest() {
        $request = new woo_controller_Request();
        $app_c = new woo_base_ApplicationRegistry::appController();
        while($cmd = $app_c->getCommand($request)) {
            print "Выполняеться ".get_class($cmd)."<br>";
            $cmd->execute($request);
        }
        $this->invokeView($app_c->getView($request));
    }

    function invokeView($target) {
        inclide("woo/view/$target.php");
        exit;
    }
}