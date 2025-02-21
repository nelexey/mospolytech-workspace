<?php

interface Shape {
    public function getArea();
    public function getPerimeter();
}

class Lesson {
    protected $topic;

    public function __construct($topic) {
        $this->topic = $topic;
    }

    public function getTopic() {
        return $this->topic;
    }
}

class Homework extends Lesson {
    private $description;

    public function __construct($topic, $description) {
        parent::__construct($topic);
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }
}

class Rectangle implements Shape {
    private $width;
    private $height;

    public function __construct($width, $height) {
        $this->width = $width;
        $this->height = $height;
    }

    public function getArea() {
        return $this->width * $this->height;
    }

    public function getPerimeter() {
        return 2 * ($this->width + $this->height);
    }
}

// Пример использования классов
$lesson = new Lesson("Геометрия: Прямоугольники");
$homework = new Homework("Геометрия: Прямоугольники", "Рассчитать площадь и периметр прямоугольника с заданными размерами");
$rectangle = new Rectangle(5, 10);

echo "Тема урока: " . $lesson->getTopic() . "<br>";
echo "Описание домашнего задания: " . $homework->getDescription() . "<br>";
echo "Площадь прямоугольника: " . $rectangle->getArea() . "<br>";
echo "Периметр прямоугольника: " . $rectangle->getPerimeter() . "<br>";
