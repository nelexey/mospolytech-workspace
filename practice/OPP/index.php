<?php

    class Cat {
        private $name;
        public $color;
        public $weight;

        public function __construct($name, $color, $weight) {
            $this->setName($name);
            $this->color = $color;
            $this->weight = $weight;
        }

        public function setName($name) {
            $this->name = $name;
        }

        public function getName() {
            return $this->name;
        }
    }

    $cat1 = new Cat("Мурзик", "Черный", 5);

    echo "Имя кота: " . $cat1->getName() . "<br>";
    echo "Цвет кота: " . $cat1->color . "<br>";
    echo "Вес кота: " . $cat1->weight . "<br>";
?>
