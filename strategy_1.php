<?php 
/*
 * Вынесение части функционала класса в несколько других классов, для упрощения
 * работы. 
 */

abstract class CostStrategy {
    abstract function cost (Lesson $lesson);
    abstract function chargeType();
}

class TimedCostStrategy extends CostStrategy {
    
    function cost(Lesson $lesson) {
        return ($lesson->getDuration() * 5);
    }
    
    function chargeType() {
        return 'Почасовая оплата';
    }
}

class FixedCostStrategy extends CostStrategy {
    
    function cost(Lesson $lesson){
        return 30;
    }
    
    public function chargeType() {
        return 'Фиксированная ставка';
    }
   
}

abstract class Lesson {
    private $duration;
    private $costStrategy;
    
    function __construct($duation, CostStrategy $strategy) {
        $this->duration = $duation;
        $this->costStrategy = $strategy;
    }
    
    function cost() {
        return $this->costStrategy->cost($this);
    }
    
    function chargeType () {
        return $this->costStrategy->chargeType();
    }
    
    function getDuration() {
        return $this->duration;
    }
}

class Seminar extends Lesson {
    
}

class Lecture extends Lesson {
    
}

$lessons = array();
$lessons[] = new Seminar(4, new TimedCostStrategy);
$lessons[] = new Lecture(4, new FixedCostStrategy);


foreach ($lessons as $lesson) {
    echo "Оплата за занятие {$lesson->cost()}.";
    echo "Тип оплаты: {$lesson->chargeType()}<br>";
}