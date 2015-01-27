<?php

/*
 * Объекты Observer получают на конструктор объект Observable и в конструкторе
 * добаляют при помощи метода attach себя как прослушивающий класс.
 * Так же сохраняет ссылку на обект Observable в переменной $login для того что
 * бы выполнять метод update только для своего обекта Observable.
 *
 * Объект Observable получает на метод attach объект observer и добавляет его в
 * список прослушивающих объектов.
 * При изменении своего статуса информирует каждый объект observer в своем списке
 * при помощи спациального метода update в котором он передает себя
 */

interface Observer {
    function update (Observable $observer);
}

abstract class LoginObserver implements Observer {
    private $login;

    function __construct(Login $login) {
        $this->login = $login;
        $login->attach($this);
    }

    function update(Observable $observable) {
        if($observable === $this->login) {
            $this->doUpdate($observable);
        }
    }

    abstract function doUpdate(Login $login);
}

interface Observable {
    function attach(Observer $observer);
    function detach(Observer $observer);
    function notify();
}

class Login implements Observable {
    const LOGIN_USER_UNKNOWN = 1;
    const LOGIN_WRONG_PASS = 2;
    const LOGIN_ACCESS = 3;
    private $status = array();
    private $observers;

    function attach(Observer $observer){
        $this->observers[] = $observer;
    }

    function detach(Observer $observer) {
        $newobservers = array();
        foreach ($this->observers as $obs) {
            if($obs !== $observer) {
                $newobservers[] = $obs;
            }
        }
        $this->observers = $newobservers;
    }

    function notify() {
        foreach ($this->observers as $obs) {
            $obs->update($this);
        }
    }

    function handleLogin($user, $pass, $ip) {
        switch (rand(1, 3)){
            case 1:
                $this->setStatus(self::LOGIN_ACCESS, $user, $ip);
                $ret = true;
                break;
            case 2:
                $this->setStatus(self::LOGIN_WRONG_PASS, $user, $ip);
                $ret = false;
                break;
            case 3:
                $this->setStatus(self::LOGIN_USER_UNKNOWN, $user, $ip);
                $ret = false;
                break;
        }
        $this->notify();
        return $ret;
    }

    private function setStatus($status, $user, $ip) {
        $this->status = array($status, $user, $ip);
    }

    function getStatus() {
        return $this->status;
    }
}

class SecurityMonitor extends LoginObserver {
    function doUpdate(Login $login) {
        $status = $login->getStatus();
        if($status[0] == Login::LOGIN_WRONG_PASS){
            print __class__."  Отправка почты системному администратору <br>";
        }
    }
}

class GeneralLogger extends LoginObserver {
    function doUpdate(Login $login) {
        $status = $login->getStatus();
        print __class__."  Регистрация в системном журнале<br>";
    }
}

class PartnershipTool extends LoginObserver {
    function doUpdate(Login $login) {
        $status = $login->getStatus();
        print __class__."  Отправка cookie-файла если адрес соответсвует списку<br>";
    }
}

$login = new Login();
new SecurityMonitor($login);
new GeneralLogger($login);
new PartnershipTool($login);
$login->handleLogin('x', '123', '127.0.0.1');

