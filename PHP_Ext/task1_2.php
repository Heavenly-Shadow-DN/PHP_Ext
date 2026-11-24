<?php
declare(strict_types=1);

// Абстрактный класс — объект создать нельзя, потому что у него нет
// реализации calculateSalary(), непонятно как считать зарплату
// "просто сотрудника". Он только задаёт общую структуру для наследников.
abstract class Employee {
    protected string $name;
    protected float $baseSalary;

    public function __construct(string $name, float $baseSalary) {
        $this->name = $name;
        $this->baseSalary = $baseSalary;
    }

    abstract public function calculateSalary(): float;

    public function getName(): string {
        return $this->name;
    }
}

class Manager extends Employee {
    public function calculateSalary(): float {
        return $this->baseSalary * 1.2; // оклад + 20% премия
    }
}

class Developer extends Employee {
    private int $overtimeHours = 0;

    public function setOvertimeHours(int $hours): void {
        $this->overtimeHours = $hours;
    }

    public function calculateSalary(): float {
        return $this->baseSalary + $this->overtimeHours * 500;
    }
}

class Intern extends Employee {
    public function calculateSalary(): float {
        return $this->baseSalary * 0.5;
    }
}

function printPayroll(array $employees): void {
    $total = 0;
    foreach ($employees as $e) {
        $salary = $e->calculateSalary();
        $total += $salary;
        echo $e->getName() . " — " . $salary . PHP_EOL;
    }
    echo "Общий фонд оплаты труда: " . $total . PHP_EOL;
}

 $employees = [
    new Manager("Иванов", 100000),
    new Developer("Петров", 90000),
    new Intern("Сидоров", 30000),
];

// переработки разработчика
 $employees[1]->setOvertimeHours(10);

printPayroll($employees);

// Вывод в терминале:
// Иванов — 120000
// Сидоров — 15000
// Общий фонд оплаты труда: 230000