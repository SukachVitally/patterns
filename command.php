<?php

/*
 * Позволяет подключать отдельные файлы с классами при помощи класса CommandFactory.
 * Файлы с классами можно просто добавлять в каталог и они автоматически будут
 * подключены при запросе
 */

abstract class Command {
    abstract function execute(CommandContext $context);
}

class CommandContext {
    private $params = array();
    private $error = '';

    function __construct() {
        $this->params = $_REQUEST;
    }

    function addParam($key, $val) {
        $this->params[$key] = $val;
    }

    function get($key) {
        return $this->params[$key];
    }

    function setError($error) {
        $this->error = $error;
    }

    function getError() {
        return $this->error;
    }
}

class CommandNotFoundException extends Exception {

}

class CommandFactory {
    private static $dir = 'commands';

    static function getCommand($action = 'Default') {
        if(preg_match('/\W/', $action)) {
            throw new Exception('Недопустимые символы в команде');
        }
        $class = UCFirst(strtolower($action)) . 'Command';
        $file = self::$dir . DIRECTORY_SEPARATOR . "{$class}.php";
        if (! file_exists($file)) {
            throw new CommandNotFoundException("Файл '$file' не найден");
        }
        require_once($file);
        if( ! class_exists($class)) {
            throw new CommandNotFoundException("Класс '$file' не обнаружен");
        }
        $cmd = new $class();
        return $cmd;
    }
}

class Controller {
    private $context;

    function __construct() {
        $this->context = new CommandContext();
    }

    function getContext() {
        return $this->context;
    }

    function process() {
        $cmd = CommandFactory::getCommand($this->context->get('action'));
        if ( ! $cmd->execute($this->context)) {
            echo 'Ошибки';
        } else {
            echo 'ok';
        }
    }
}

$controller = new Controller();
$context = $controller->getContext();
$context->addParam('action', 'Feedback');
$context->addParam('email', 'qwe@qwe.qwe');
$context->addParam('msg', 'hello');
$context->addParam('topic', 'new');
$controller->process();