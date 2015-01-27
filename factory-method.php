<?php

/*
 * создает опередленный объект для своего класса
 * Недостатки: для каждого класса необходими собсвенный класс CommsManager
 * В отличае от абстрактной фабрики, в фабричном методе родительский класс
 * может содержать не только абстрактные методы но и реализацию.
 */

abstract class ApptEncoder {
    abstract function encode();
}

class BloggsApptEncoder extends ApptEncoder {
    function encode() {
        return "Данные о встрече закодированны в формате BloggsCal <br>";
    }
}

class MegaApptEncoder extends ApptEncoder {
    function encode() {
        return "Данные о встрече закодированны в формате MegaCal <br>";
    }
}

abstract class CommsManager {
    abstract function getHeaderText();
    abstract function getApptEncoder();
    abstract function getFooterText();
}

class BloggsCommsManager extends CommsManager {
    function getHeaderText() {
        return 'BloggsCal верхний колонтитул <br>';
    }
    
    function getApptEncoder() {
        return new BloggsApptEncoder();
    }
    
    function getFooterText() {
        return 'BloggsCal нижний колонтитул<br>';
    }
}

$comms = new BloggsCommsManager;
print $comms->getApptEncoder()->encode();