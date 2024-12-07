# Pohoda XML

![Build Status](https://github.com/alex-kalanis/pohoda/actions/workflows/test.yml/badge.svg)(https://github.com/alex-kalanis/pohoda/actions)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/pohoda/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/pohoda/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/pohoda/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/pohoda)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.1-8892BF.svg)](https://php.net/)
[![Total Downloads](https://img.shields.io/packagist/dt/alex-kalanis/pohoda.svg?style=flat-square)](https://packagist.org/packages/alex-kalanis/pohoda)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/pohoda/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/pohoda/?branch=master)

Library for manipulation with data, which came as XML from Pohoda mServer.

Pohoda is an accounting software for Czech Republic, Slovakia and probably few other countries.

#### What is different:

Usage of phpunit, extended tests, phpstan 1.12, deeper type checking

## Installation

Add to *composer.json*:

```bash
composer.phar require alex-kalanis/pohoda
```

## Example of order imports

Examples of importing each type - more in *spec* folder.

```php
use Riesenia\Pohoda;

$pohoda = new Pohoda('ICO');

// create file
$pohoda->open($filename, 'i_obj1', 'Import orders');

// create order
$order = $pohoda->createOrder([
    'numberOrder' => $order_number,
    'isReserved' => true,
    'date' => $created,
    'text' => '...',
    'partnerIdentity' => [
        'address' => [
            'name' => $billing_name,
            'street' => $billing_street,
            'city' => $billing_city,
            'zip' => $billing_zip,
            'email' => $email,
            'phone' => $phone
        ],
        'shipToAddress' => [
            'name' => $shipping_name,
            'street' => $shipping_street,
            'city' => $shipping_city,
            'zip' => $shipping_zip,
            'email' => $email,
            'phone' => $phone
        ]
    ]
]);

// add items
foreach ($items as $item) {
    $order->addItem([
        'code' => $item->code,
        'text' => $item->text,
        'quantity' => $item->quantity,
        'payVAT' => false,
        'rateVAT' => $item->rate,
        'homeCurrency' => [
            'unitPrice' => $item->unit_price
        ],
        'stockItem' => [
            'stockItem' => [
                'id' => $item->pohoda_id
            ]
        ]
    ]);
}

// add summary
$order->addSummary([
    'roundingDocument' => 'none'
]);

// add order to import (identified by $order_number)
$pohoda->addItem($order_number, $order);

// finish import file
$pohoda->close();
```

## Exporting stored goods

The creation of request to export goods is realized by creating *ListRequest*.

```php
use Riesenia\Pohoda;

$pohoda = new Pohoda('ICO');

// create request for export
$pohoda->open($filename, 'e_zas1', 'Export stock');

$request = $pohoda->createListRequest([
    'type' => 'Stock'
]);

// optional filter
$request->addUserFilterName('MyFilter');

$pohoda->addItem('Export 001', $request);

$pohoda->close();
```

The rest of the processing itself is simple - just call `next` and got *SimpleXMLElement* with entity.

```php
// load file
$pohoda->loadStock($filename);

while ($stock = $pohoda->next()) {
    // access header
    $header = $stock->children('stk', true)->stockHeader;

    // ...
}
```

## Příklad smazání zásob

Při mazání je potřeba vytvořit agendu s prázdnymi daty a nastavit jim *delete* actionType.

```php
use Riesenia\Pohoda;

$pohoda = new Pohoda('ICO');

// create request for deletion
$pohoda->open($filename, 'd_zas1', 'Delete stock');

$stock = $pohoda->createStock([]);

$stock->addActionType('delete', [
    'code' => $code
]);

$pohoda->addItem($code, $stock);

$pohoda->close();
```

## Použití *ValueTransformer* pro úpravu hodnot

Pomocí rozhraní *ValueTransformer* můžeme implementovať transformátor, který změní všechny údaje. Příklad pro úpravu všech hodnot na velká písmena:

```php
use Riesenia\Pohoda;

class Capitalizer implements \Riesenia\Pohoda\ValueTransformer\ValueTransformer
{
    public function transform(string $value): string
    {
        return \strtoupper($value);
    }
}

// Register the capitalizer to be used to capitalize values
Pohoda::$transformers[] = new Capitalizer();

$pohoda = new Pohoda('ICO');

...
```
