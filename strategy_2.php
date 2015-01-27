<?php

abstract class Question {
    protected $prompt;
    protected $marker;

    function __construct($prompt, Marker $marker) {
        $this->marker = $marker;
        $this->prompt = $prompt;
    }

    function mark($response) {
        return $this->marker->mark($response);
    }
}

abstract class Marker {
    protected $test;

    function __construct($test) {
        $this->test = $test;
    }

    abstract function mark($response);
}

class MarkLogicMarker extends Marker {
    function __construct($test) {
        parent::__construct($test);
    }

    function mark($response) {
        return true;
    }
}

class MatchMarker extends Marker {
    function mark($response) {
        return ($this->test == $response);
    }
}

class RegexpMarker extends Marker {
    function mark($response) {
        return preg_match($this->test,  $response);
    }
}

class TextQuestion extends Question {

}

class AVQuestion extends Question {
    
}

$markers = array(
    new RegexpMarker("П.ть"),
    new MatchMarker("Пять"),
    new MarkLogicMarker('$input equals "Пять"')
);

foreach ($markers as $marker) {
    print get_class($marker) ."<br>";
    $question = new TextQuestion('Сколько лучей у Кремлевской звезды ?', $marker);
    foreach(array('Пять', 'Четыре') as $response) {
        print "Ответ: $response";
        if($question->mark($response)){
            print "Правильно !!! <br>";
        } else {
            print "Неверно ! <br>";
        }
    }

}
