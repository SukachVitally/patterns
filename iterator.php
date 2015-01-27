<?php

/**
* Паттерн итератор предоставляет механизм последовательного перебора элементов
* коллекции без раскрытия реализации коллекции.
*
* Перебор элементов выполняется объектом итератора, а не самой коллекцией.
* Это упрощает интерфейс и реализацию коллекции, а также способствует более
* логичному распределению обязанностей.
*/


/**
 * Наличие общего интерфейса удобно для клиента, поскольку клиент отделяется
 * от реализации коллекции объектов.
 *
 * ConcreteAggregate содержит коллекцию объектов и реализует метод, который
 * возвращает итератор для этой коллекции.
 */
interface IAggregate
{
    /**
     * Каждая разновидность ConcreteAggregate отвечает за создание
     * экземпляра Concrete Iterator,
     * который может использоваться для перебора своей коллекции объектов.
     */
    public function createIterator();
}

/**
 * Интерфейс Iterator должен быть реализован всеми итераторами.
 *
 * ConcreteIterator отвечает за управление текущей позицией перебора.
 */
interface IIterator
{
    /**
     * @abstract
     * @return boolean есть ли следующий элемент в коллекции
     */
    public function hasNext();

    /**
     * @abstract
     * @return mixed следующий элемент массива
     */
    public function next();

    /**
     * Удаляет текущий элемент коллекции
     * @abstract
     * @return void
     */
    public function remove();
}

/**
 * В моём примере обе коллекции используют одинаковый итератор - итератор массива.
 */
class ConcreteAggregate1 implements IAggregate
{
    /**
     * @var Item[] $items
     */
    public $items = array();

    public function __construct()
    {
        $this->items = array(
            new Item(1, 2),
            new Item(1, 2),
            new Item(1, 2),
        );
    }

    public function createIterator()
    {
        return new ConcreteIterator1($this->items);
    }
}

class ConcreteAggregate2 implements IAggregate
{
    /**
     * @var Item[] $items
     */
    public $items = array();

    public function __construct()
    {
        $this->items = array(
            new Item(2, 3),
            new Item(2, 3),
            new Item(2, 3),
        );
    }

    public function createIterator()
    {
        return new ConcreteIterator1($this->items);
    }
}

class ConcreteIterator1 implements IIterator
{
    /**
     * @var Item[] $items
     */
    protected $items = array();

    /**
     * @var int $position хранит текущую позицию перебора в массиве
     */
    public $position = 0;

    /**
     * @param $items массив объектов, для перебора которых создается итератор
     */
    public function __construct($items)
    {
        $this->items = $items;
    }

    public function hasNext()
    {
        if ($this->position >= count($this->items) || count($this->items) == 0) {
            return (false);
        } else {
            return (true);
        }
    }

    public function next()
    {
        $menuItem = $this->items[$this->position];
        $this->position++;
        return ($menuItem);
    }

    public function remove()
    {
        if ($this->position <= 0) {
            throw new \Exception('Нельзя вызывать remove до вызова хотя бы одного next()');
        }
        if ($this->items[$this->position - 1] != null) {
            for ($i = $this->position - 1; $i < count($this->items); $i++) {
                $this->items[$i] = $this->items[$i + 1];
            }
            $this->items[count($this->items) - 1] = null;
        }
    }
}

class Client
{
    /**
     * @var ConcreteAggregate1 $aggregate1
     */
    public $aggregate1;
    /**
     * @var ConcreteAggregate2 $aggregate2
     */
    public $aggregate2;

    public function __construct($aggregate1, $aggregate2)
    {
        $this->aggregate1 = $aggregate1;
        $this->aggregate2 = $aggregate2;
    }

    public function printAggregatesItems()
    {
        $iterator1 = $this->aggregate1->createIterator();
        echo "\n First";
        $this->printIteratorItems($iterator1);

        $iterator2 = $this->aggregate2->createIterator();
        echo "\n\n Second";
        $this->printIteratorItems($iterator2);
    }

    /**
     * @param $iterator IIterator
     */
    private function printIteratorItems($iterator)
    {
        while ($iterator->hasNext()) {
            $item = $iterator->next();
            echo "\n $item->name $item->price $item->description";
        }
    }
}

class Item
{
    public $price;
    public $name;
    public $description;

    public function __construct($name, $price, $description = '')
    {
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }
}


$runner = new Client(new ConcreteAggregate1(), new ConcreteAggregate2());
$runner->printAggregatesItems();
