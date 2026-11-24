<?php
declare(strict_types=1);

class Vehicle {
    protected string $brand;
    protected int $maxSpeed;

    public function __construct(string $brand, int $maxSpeed) {
        $this->brand = $brand;
        $this->maxSpeed = $maxSpeed;
    }

    public function getInfo(): string {
        return "Марка: {$this->brand}, макс. скорость: {$this->maxSpeed} км/ч";
    }
}

class Car extends Vehicle {
    private string $fuelType;

    public function __construct(string $brand, int $maxSpeed, string $fuelType) {
        parent::__construct($brand, $maxSpeed);
        $this->fuelType = $fuelType;
    }

    public function getInfo(): string {
        return parent::getInfo() . ", тип топлива: {$this->fuelType}";
    }
}

class Airplane extends Vehicle {
    private float $wingspan;

    public function __construct(string $brand, int $maxSpeed, float $wingspan) {
        parent::__construct($brand, $maxSpeed);
        $this->wingspan = $wingspan;
    }

    public function getInfo(): string {
        return parent::getInfo() . ", размах крыльев: {$this->wingspan} м";
    }
}

// демонстрация
 $vehicles = [
    new Vehicle("Урал", 90),
    new Car("Lada", 180, "бензин"),
    new Airplane("Boeing", 900, 60.1),
];

foreach ($vehicles as $v) {
    echo $v->getInfo() . PHP_EOL;
}

var_dump($vehicles[1] instanceof Vehicle);
var_dump($vehicles[2] instanceof Vehicle);

// Вывод в терминале:
// Марка: Урал, макс. скорость: 90 км/ч
// Марка: Boeing, макс. скорость: 900 км/ч, размах крыльев: 60.1 м
// bool(true)
// bool(true)