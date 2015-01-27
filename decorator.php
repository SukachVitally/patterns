<?php

/*
 * Формирует оболочку вокруг дочернего объекта. Дочерний класс делегирует 
 * декоратору свои фунции. Чем больше функций в дочернем классе, тем более тесная 
 * связь в классе декораторе (больше ошибок). 
 */

abstract class Tile {
    abstract function getWealthFactor();
}

class Plains extends Tile {
    private $wealthfactor = 2;

    function getWealthFactor() {
        return $this->wealthfactor;
    }
}

abstract class TileDecorator extends Tile {
    protected $tile;

    function __construct(Tile $tile) {
        $this->tile = $tile;
    }
}

class DiamondDecorator extends TileDecorator {
    function getWealthFactor() {
        return $this->tile->getWealthFactor()  + 2;
    }
}

class PollutionDecorator extends TileDecorator {
    function getWealthFactor() {
        return $this->tile->getWealthFactor()  - 4;
    }
}

$tile = new Plains();
var_dump($tile);
var_dump($tile->getWealthFactor());

$tile = new DiamondDecorator(new Plains());
var_dump($tile);
var_dump($tile->getWealthFactor());

$tile = new PollutionDecorator(new DiamondDecorator(new Plains()));
var_dump($tile);
var_dump($tile->getWealthFactor());
