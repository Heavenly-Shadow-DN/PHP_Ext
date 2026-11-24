<?php
declare(strict_types=1);

trait LoggerTrait {
    private array $logs = [];

    public function log(string $message): void {
        $this->logs[] = "[" . date('Y-m-d H:i:s') . "] " . $message;
    }

    public function getLogs(): array {
        return $this->logs;
    }

    public function clearLogs(): void {
        $this->logs = [];
    }
}

class UserService {
    use LoggerTrait;

    public function register(string $username): void {
        // тут могла бы быть реальная регистрация
        $this->log("Зарегистрирован пользователь: {$username}");
    }
}

class OrderService {
    use LoggerTrait;

    public function createOrder(int $orderId, float $total): void {
        $this->log("Создан заказ №{$orderId} на сумму {$total} руб.");
    }
}

// Трейт здесь удобнее наследования: UserService и OrderService никак не
// связаны между собой, выделять для них общего родителя ради лога неправильно,
// а трейт просто вставляет одну и ту же логику в оба класса.

 $userService = new UserService();
 $orderService = new OrderService();

 $userService->register("ivan");
 $userService->register("anna");
 $orderService->createOrder(1, 2500.50);
 $orderService->createOrder(2, 999.99);

echo "Лог UserService:" . PHP_EOL;
foreach ($userService->getLogs() as $line) {
    echo $line . PHP_EOL;
}

echo PHP_EOL . "Лог OrderService:" . PHP_EOL;
foreach ($orderService->getLogs() as $line) {
    echo $line . PHP_EOL;
}

 $userService->clearLogs();

echo PHP_EOL . "После очистки UserService:" . PHP_EOL;
echo "UserService: " . count($userService->getLogs()) . " записей" . PHP_EOL;
echo "OrderService: " . count($orderService->getLogs()) . " записей (журнал не тронут)" . PHP_EOL;

// Вывод в терминале:
// Лог UserService:
// [2026-11-24 11:15:57] Зарегистрирован пользователь: ivan
// Лог OrderService:
// [2026-11-24 11:15:57] Создан заказ №1 на сумму 2500.5 руб.
// [2026-11-24 11:15:57] Создан заказ №2 на сумму 999.99 руб.
// UserService: 0 записей