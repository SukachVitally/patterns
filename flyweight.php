<?php

/*
 * Паттерн приспособленец
 * Используеться для присвоения определенному значению (в данном случае символу)
 * определенного объекта. Для того что бы не создавать большое количество объектов
 * используеться пулл в котором храняться все возможные вариации объектов.
 * По мере необходимости фабрика приспособленца берет из пулла необходимый объект
 * вместо создания каждый раз объекта с нуля.
 */

// "FlyweightFactory"
class CharacterFactory
{
    private $characters = array();
    public function GetCharacter($key)
    {
        // Uses "lazy initialization"
        if (!array_key_exists($key, $this->characters))
        {
            switch ($key)
            {
                case 'A': $this->characters[$key] = new CharacterA(); break;
                case 'B': $this->characters[$key] = new CharacterB(); break;
                //...
                case 'Z': $this->characters[$key] = new CharacterZ(); break;
            }
        }
        return $this->characters[$key];
    }
}

// "Flyweight"
abstract class Character
{
    protected $symbol;
    protected $width;
    protected $height;
    protected $ascent;
    protected $descent;
    protected $pointSize;

    public abstract function Display($pointSize);
}

// "ConcreteFlyweight"

class CharacterA extends Character
{
    // Constructor
    public function __construct()
    {
        $this->symbol = 'A';
        $this->height = 100;
        $this->width = 120;
        $this->ascent = 70;
        $this->descent = 0;
    }

    public function Display($pointSize)
    {
        $this->pointSize = $pointSize;
        return $this->symbol." (pointsize ".$this->pointSize.")";
    }
}

// "ConcreteFlyweight"

class CharacterB extends Character
{
    // Constructor
    public function __construct()
    {
        $this->symbol = 'B';
        $this->height = 100;
        $this->width = 140;
        $this->ascent = 72;
        $this->descent = 0;
    }

    public function  Display($pointSize)
    {
        $this->pointSize = $pointSize;
        return $this->symbol." (pointsize ".$this->pointSize.")";
    }

}

// ... C, D, E, etc.

// "ConcreteFlyweight"

class CharacterZ extends Character
{
    // Constructor
    public function __construct()
    {
        $this->symbol = 'Z';
        $this->height = 100;
        $this->width = 100;
        $this->ascent = 68;
        $this->descent = 0;
    }

    public function  Display($pointSize)
    {
        $this->pointSize = $pointSize;
        return $this->symbol." (pointsize ".$this->pointSize.")";
    }
}

$document="AAZZBBZB";
// Build a document with text
$chars=str_split($document);
var_dump($chars);

$f = new CharacterFactory();

// extrinsic state
$pointSize = 0;

// For each character use a flyweight object
foreach ($chars as $key)
{
    $pointSize++;
    $character = $f->GetCharacter($key);
    var_dump($character->Display($pointSize));
}
