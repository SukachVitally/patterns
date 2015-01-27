<?php
/*
 * Копозит - объект в который могут входить другие объекты (листья), которыми он реализует
 * некоторые свои свойства.
 * В данном случае  класс Army являеться композитом и реализует свойство bombardStrength
 * подсчетом значение bombardStrength своих составных обектов
 */

abstract class Unit {
    function getComposite() {
        return null;
    }
    abstract function bombardStrength();
}

class Archer extends Unit {
    function bombardStrength() {
        return 4;
    }
}

class LaserCannonUnit extends Unit {
    function bombardStrength() {
        return 44;
    }
}

abstract class CompositeUnit extends Unit {
    protected $units = array();

    function getComposite(){
        return $this;
    }

    function removeUnit(Unit $unit){
        $units = array();
        foreach ($this->units as $thisunit) {
            if($unit !== $thisunit) {
                $units[] = $thisunits;
            }
        }
        $this->units = $units;
    }

    function addUnit(Unit $unit) {
        if(in_array($unit, $this->units, true)) {
            return;
        }
        $this->units[] = $unit;
    }
}

class Army extends CompositeUnit {

    function bombardStrength() {
        $ret = 0;
        foreach ($this->units as $unit) {
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }
}

class UnitScript {
    static function joinExisting (Unit $newUnit, Unit $occupyingUnit) {
        if (! is_null($comp = $occupyingUnit->getComposite())){
            $comp->addUnit($newUnit);
        } else {
            $comp = new Army();
            $comp->addUnit($occupyingUnit);
            $comp->addUnit($newUnit);
        }
        return $comp;
    }
}

$main_army = new Army();
UnitScript::joinExisting(new Archer, $main_army);
UnitScript::joinExisting(new LaserCannonUnit, $main_army);

$sub_army = new Army();
UnitScript::joinExisting(new Archer, $sub_army);
UnitScript::joinExisting(new Archer, $sub_army);
UnitScript::joinExisting(new Archer, $sub_army);

UnitScript::joinExisting($sub_army, $main_army);

var_dump($main_army);
var_dump("Атакующая сила: {$main_army->bombardStrength()} <br>");

