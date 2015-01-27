<?php
/*
 * Создание одной точки входа. Используетсья для упрощения использования и группировки
 * кода (стороннего, может даже процедурного)
 */


// SOURCES start //
function getProductFileLines($file) {
    return file($file);
}

function getProductObjectFromId($id, $productname) {
    return new Product($id, $productname);
}

function getNameFromLine($line) {
    if(preg_match("/.*-(.*)\s\d+/", $line, $array)) {
        return str_replace('_', ' ', $array[1]);
    }
    return '';
}

function getIDFromLine($line) {
    if(preg_match("/^(\d{1,3})-/", $line, $array)) {
        return $array[1];
    }
    return -1;
}

class Product {
    public $id;
    public $name;

    function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }
}
// SOURCES end //

//run start
$lines = getProductFileLines('test.txt');
$objects = array();
foreach ($lines as $line) {
    $id = getIDFromLine($line);
    $name = getNameFromLine($line);
    $objects[$id] = getProductObjectFromId($id, $name);
}
// run end

class ProductFacade {
    private $products = array();

    function __construct($file) {
        $this->file = $file;
        $this->compile();
    }

    private function compile(){
        $lines = getProductFileLines($this->file);
        foreach ($lines as $line) {
            $id = getIDFromLine($line);
            $name = getNameFromLine($line);
            $this->products[$id] = getProductObjectFromId($id, $name);
        }
    }

    function getProducts() {
        return $this->products;
    }

    function getProduct($id) {
        return $this->products[$id];
    }
}

$facade = new ProductFacade('test.txt');
$facade->getProduct(234);