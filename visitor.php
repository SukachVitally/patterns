<?php

/*
 * Предотавляет интерфейс для прохождения по всем узлам Composite для выполнения
 * задач не связанных с задачами узлов. При чем для каждого Класса узла в Visitor
 * должен присутсвовать специальный метод, что позволяет реализовывать различные
 * функции к различным объектам.
 * Идеально подходит для composite но может использоваться в других патеррнах.
 */

abstract class Unit {
    protected $depth = 0;

    function getComposite() {
        return null;
    }

    abstract function bombardStrength();

    function accept(ArmyVisitor $visitor) {
        $method = "visit".get_class($this);
        $visitor->$method($this);
    }

    protected function setDepth($depth) {
        $this->depth = $depth;
    }

    function getDepth(){
        return $this->depth;
    }
}

class Archer extends Unit {
    function bombardStrength() {
        return 4;
    }
}

class Cavalry extends Unit {
    function bombardStrength() {
        return 2;
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
        foreach($this->units as $thisunit){
            if($unit === $thisunit){
                return;
            }
        }
        $unit->setDepth($this->depth + 1);
        $this->units[] = $unit;
    }

    function accept(ArmyVisitor $visitor) {
        parent::accept($visitor);
        foreach($this->units as $thisunit) {
            $thisunit->accept($visitor);
        }
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

abstract class ArmyVisitor{
    abstract function visit(Unit $node);

    function visitArcher(Archer $node) {
        $this->visit($node);
    }

    function visitCavalry(Cavalry $node) {
        $this->visit($node);
    }

    function visitLaserCannonUnit(LaserCannonUnit $node) {
        $this->visit($node);
    }

    function visitTroopCarrierUnit(TroopCarrierUnit $node) {
        $this->visit($node);
    }

    function visitArmy(Army $node) {
        $this->visit($node);
    }
}

class TextDumpArmyVisitor extends ArmyVisitor {
    private $text="";

    function visit(Unit $node) {
        $ret = "";
        $ret .= "Глубина: ".$node->getDepth().' ';
        $ret .= get_class($node) .": ";
        $ret .= "Огневая мощь: ".$node->bombardStrength().'</br>';
        $this->text .= $ret;
    }

    function getText() {
        return $this->text;
    }
}

$main_army = new Army();
$main_army->addUnit(new Archer());
$main_army->addUnit(new LaserCannonUnit());
$main_army->addUnit(new Cavalry());
$textdump = new TextDumpArmyVisitor();
$main_army->accept($textdump);
print $textdump->getText();