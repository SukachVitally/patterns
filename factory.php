<?php

abstract class Employee {
    protected $name;
    private static $types = array(
        'Minion',
        'CluedUp',
        'WellConnected'
    );
    
    static function recruit($name) {
        $num = rand(1, count(self::$types)) - 1;
        $class = self::$types[$num];
        return new $class($name);
    }
    
    function __construct($name) {
        $this->name = $name;
    }
    
    abstract function fire();
    
}

class Minion extends Employee {
    function fire() {
        print "{$this->name}: убери со стола<br>";
    }
}

class CluedUp extends Employee {
    function fire() {
        print "{$this->name}: вызови адвоката<br>";
    }
}

class WellConnected extends Employee {
    function fire() {
        print "{$this->name}: позвони папику<br>";
    }
}

class NastyBoss {
    private $emploees = array();
    
    function addEmployee(Employee $employeeName) {
        $this->emploees[] = $employeeName;
    }
    
    function projectFails() {
        if (count($this->emploees) > 0) {
            $emp = array_pop($this->emploees);
            $emp->fire();
        }
    }
}

$boss = new NastyBoss();
$boss->addEmployee(Employee::recruit('Игорь'));
$boss->addEmployee(Employee::recruit('Владимир'));
$boss->addEmployee(Employee::recruit('Мария'));
$boss->projectFails();
$boss->projectFails();
$boss->projectFails();