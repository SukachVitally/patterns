<?php

/*
 * Цепочка обязанностей.
 * Определяет цепочку элементов, которые передают через себя по очереди
 * событие, срабатывая на него по необходимости.
 */

abstract class Logger {

    const ERR = 3;
    const NOTICE = 5;
    const DEBUG = 7;

    protected $mask;
    // The next element in the chain of responsibility
    protected $next;

    public function __construct($mask) {
        $this->mask = $mask;
    }

    public function setNext(Logger $log) {
        $this->next = $log;
        return $log;
    }

    public function message($msg, $priority) {
        if ($priority <= $this->mask) {
            $this->writeMessage($msg);
        }

        if ($this->next != null) {
            $this->next->message($msg, $priority);
        }
    }

    protected abstract function writeMessage($msg);
}

class StdoutLogger extends Logger {

    protected function writeMessage($msg) {
        var_dump(sprintf("Writing to stdout: %s\n", $msg)) ;
    }

}

class EmailLogger extends Logger {

    protected function writeMessage($msg) {
        var_dump(sprintf("Sending via email: %s\n", $msg));
    }

}

class StderrLogger extends Logger {

    protected function writeMessage($msg) {
        var_dump(sprintf("Sending to stderr: %s\n", $msg));
    }

}


// строим цепочку обязанностей
$logger = new StdoutLogger(Logger::DEBUG);
$logger1 = $logger->setNext(new EmailLogger(Logger::NOTICE));
$logger2 = $logger1->setNext(new StderrLogger(Logger::ERR));

// Handled by StdoutLogger
$logger->message("Entering function y.", Logger::DEBUG);

// Handled by StdoutLogger and EmailLogger
$logger->message("Step1 completed.", Logger::NOTICE);

// Handled by all three loggers
$logger->message("An error has occurred.", Logger::ERR);

