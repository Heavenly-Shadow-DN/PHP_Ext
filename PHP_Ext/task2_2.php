<?php
declare(strict_types=1);

interface ReportFormatterInterface {
    public function format(array $data): string;
}

interface ReportHeaderInterface {
    public const SEPARATOR = "====================";
    public function getHeader(): string;
}

class HtmlFormatter implements ReportFormatterInterface {
    public function format(array $data): string {
        $items = "";
        foreach ($data as $item) {
            $items .= "<li>" . $item . "</li>";
        }
        return "<ul>" . $items . "</ul>";
    }
}

class CsvFormatter implements ReportFormatterInterface {
    public function format(array $data): string {
        return implode(";", $data);
    }
}

class SalesReport implements ReportFormatterInterface, ReportHeaderInterface {
    public array $sales;

    public function __construct(array $sales) {
        $this->sales = $sales;
    }

    public function format(array $data): string {
        $lines = [];
        foreach ($data as $product => $sum) {
            $lines[] = "Продукт: {$product} — сумма: {$sum} руб.";
        }
        return implode(PHP_EOL, $lines);
    }

    public function getHeader(): string {
        return "Отчёт о продажах за текущий период";
    }
}

function renderReport(ReportFormatterInterface $report): void {
    echo $report->format($report->sales) . PHP_EOL;
}

 $report = new SalesReport(["Хлеб" => 1200, "Молоко" => 3400, "Сыр" => 5600]);

echo ReportHeaderInterface::SEPARATOR . PHP_EOL;
echo $report->getHeader() . PHP_EOL;
echo ReportHeaderInterface::SEPARATOR . PHP_EOL;

// один и тот же объект SalesReport передаётся в функцию через интерфейс
renderReport($report);

echo PHP_EOL . "HTML: " . (new HtmlFormatter())->format(["Хлеб", "Молоко", "Сыр"]) . PHP_EOL;
echo "CSV: " . (new CsvFormatter())->format(array_keys($report->sales)) . PHP_EOL;
echo "SEPARATOR: " . ReportHeaderInterface::SEPARATOR . PHP_EOL;

// Вывод в терминале:
// ====================
// Отчёт о продажах за текущий период
// ====================
// Продукт: Хлеб — сумма: 1200 руб.
// Продукт: Молоко — сумма: 3400 руб.
// Продукт: Сыр — сумма: 5600 руб.
// HTML: <ul><li>Хлеб</li><li>Молоко</li><li>Сыр</li></ul>
// CSV: Хлеб;Молоко;Сыр
// SEPARATOR: ====================