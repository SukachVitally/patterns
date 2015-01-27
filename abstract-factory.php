<?php

/*
 * Предоставляет пользователю интерфейс абстрактного класса.
 * Пользователь использует данный интерфейс к конкретному классу фабрики.
 * Из недостатков требует новый подкласс конкретной фабрики для каждого семейства.
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
///////////////////////////////////////////////////////////////////////////
abstract class TldEncoder {
    abstract function encode();
}

class BloggsTldEncoder extends TldEncoder {
    function encode() {
        return "Данные TLd закодированны в формате BloggsCal <br>";
    }
}
///////////////////////////////////////////////////////////////////////////
abstract class ContactEncoder {
    abstract function encode();
}

class BloggsContactEncoder extends ContactEncoder {
    function encode() {
        return "Данные ContactEncoder закодированны в формате BloggsCal <br>";
    }
}
///////////////////////////////////////////////////////////////////////////
abstract class CommsManager {
    abstract function getHeaderText();
    abstract function getApptEncoder();
    abstract function getTldEncoder();
    abstract function getContactEncoder();
    abstract function getFooterText();
}

class BloggsCommsManager extends CommsManager {
    function getHeaderText() {
        return 'BloggsCal верхний колонтитул <br>';
    }
    
    function getApptEncoder() {
        return new BloggsApptEncoder();
    }
    
    function getTldEncoder() {
        return new BloggsTldEncoder();
    }
    
    function getContactEncoder() {
        return new BloggContactEncoder();
    }
    
    function getFooterText() {
        return 'BloggsCal нижний колонтитул<br>';
    }
}
///////////////////////////////////////////////////////////////////////////
$comms = new BloggsCommsManager;
print $comms->getApptEncoder()->encode();