<?php
declare(strict_types=1);

trait JsonExportTrait {
    public function export(): string {
        return json_encode(get_object_vars($this), JSON_UNESCAPED_UNICODE);
    }

    public function getFormat(): string {
        return "JSON";
    }
}

trait XmlExportTrait {
    public function export(): string {
        $vars = get_object_vars($this);
        $xml = "<product>";
        foreach ($vars as $key => $value) {
            $xml .= "<{$key}>{$value}</{$key}>";
        }
        return $xml . "</product>";
    }

    public function getFormat(): string {
        return "XML";
    }
}

trait PriceTrait {
    public function getPriceWithTax(float $tax): float {
        return $this->price * (1 + $tax);
    }
}

class Product {
    use JsonExportTrait, XmlExportTrait, PriceTrait {
        JsonExportTrait::export insteadof XmlExportTrait;
        XmlExportTrait::export as exportToXml;
        JsonExportTrait::getFormat insteadof XmlExportTrait;
        XmlExportTrait::getFormat as getXmlFormat;
    }

    public string $name;
    public float $price;

    public function __construct(string $name, float $price) {
        $this->name = $name;
        $this->price = $price;
    }

    // Метод класса переопределяет метод трейта: вызовется именно эта версия,
    // а не getFormat() из JsonExportTrait. Приоритет: класс > трейт > родитель.
    public function getFormat(): string {
        return "Product format";
    }
}

 $p = new Product("Ноутбук", 50000);

echo "JSON: " . $p->export() . PHP_EOL;
echo "XML: " . $p->exportToXml() . PHP_EOL;
echo "getFormat(): " . $p->getFormat() . PHP_EOL;
echo "getXmlFormat(): " . $p->getXmlFormat() . PHP_EOL;
echo "Цена с налогом 20%: " . $p->getPriceWithTax(0.2) . PHP_EOL;

// Вывод в терминале:
// JSON: {"name":"Ноутбук","price":50000}
// XML: <product><name>Ноутбук</name><price>50000</price></product>
// getFormat(): Product format
// getXmlFormat(): XML
// Цена с налогом 20%: 60000