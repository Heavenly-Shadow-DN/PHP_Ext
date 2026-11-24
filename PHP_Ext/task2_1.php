<?php
declare(strict_types=1);

interface PaymentInterface {
    public function pay(float $amount): bool;
    public function refund(float $amount): bool;
    public function getMethodName(): string;
}

class CreditCard implements PaymentInterface {
    private float $limit;

    public function __construct(float $limit) {
        $this->limit = $limit;
    }

    public function pay(float $amount): bool {
        return $amount <= $this->limit;
    }

    public function refund(float $amount): bool {
        return true; // лимит не трогаем, возврат всегда ок
    }

    public function getMethodName(): string {
        return "CreditCard";
    }
}

class PayPal implements PaymentInterface {
    private float $balance;

    public function __construct(float $balance) {
        $this->balance = $balance;
    }

    public function pay(float $amount): bool {
        if ($amount > $this->balance) {
            return false;
        }
        $this->balance -= $amount;
        return true;
    }

    public function refund(float $amount): bool {
        $this->balance += $amount;
        return true;
    }

    public function getMethodName(): string {
        return "PayPal";
    }
}

class Cash implements PaymentInterface {
    public function pay(float $amount): bool {
        return true;
    }

    public function refund(float $amount): bool {
        return true;
    }

    public function getMethodName(): string {
        return "Cash";
    }
}

function checkout(PaymentInterface $method, float $amount): void {
    $result = $method->pay($amount) ? "успешно" : "отказ";
    echo $method->getMethodName() . ": оплата " . $amount . " — " . $result . PHP_EOL;
}

 $card = new CreditCard(5000);
 $paypal = new PayPal(1000);
 $cash = new Cash();

checkout($card, 3000);   // успешно
checkout($card, 8000);   // отказ, больше лимита
checkout($paypal, 500);  // успешно
checkout($paypal, 5000); // отказ, не хватает на балансе
checkout($cash, 100000); // всегда успешно

// Вывод в терминале:
// CreditCard: оплата 3000 — успешно
// CreditCard: оплата 8000 — отказ
// PayPal: оплата 500 — успешно
// PayPal: оплата 5000 — отказ
// Cash: оплата 100000 — успешно