# Pohoda XML

[![Build Status](https://img.shields.io/travis/riesenia/pohoda/master.svg?style=flat-square)](https://travis-ci.org/riesenia/pohoda)
[![Latest Version](https://img.shields.io/packagist/v/riesenia/pohoda.svg?style=flat-square)](https://packagist.org/packages/riesenia/pohoda)
[![Total Downloads](https://img.shields.io/packagist/dt/riesenia/pohoda.svg?style=flat-square)](https://packagist.org/packages/riesenia/pohoda)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

## Inštalácia

Pridaním do *composer.json*:

```json
{
    "require": {
        "riesenia/pohoda": "~1.0"
    }
}
```

## Príklad importu objednávok

Príklady pre import jednotlivých typov viď. *spec* folder.

```php
use Riesenia\Pohoda;

$pohoda = new Pohoda('ICO');

// create file
$pohoda->open($filename, 'Import orders');

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

## Príklad exportu zásob

Vytvorenie príkazu na export sa realizuje prostredníctvom vytvorenia *ListRequest*.

```php
use Riesenia\Pohoda;

$pohoda = new Pohoda('ICO');

// create request for export
$pohoda->open($filename, 'Export stock');

$request = $pohoda->createListRequest([
    'type' => 'Stock'
]);

// optional filter
$request->addUserFilterName('MyFilter');

$pohoda->addItem('Export 001', $request);

$pohoda->close();
```

Samotné spracovanie dát je riešené jednoducho - volanie `next` vracia *SimpleXMLElement* s danou entitou.

```php
// load file
$pohoda->loadStock($filename);

while ($stock = $pohoda->next()) {
    // access header
    $header = $stock->children('stk', true)->stockHeader;

    // ...
}
```

## Príklad zmazania zásoby

Pri mazaní je potrebné poslať prázdne dáta a nastaviť *delete* actionType.

```php
use Riesenia\Pohoda;

$pohoda = new Pohoda('ICO');

$pohoda->open($filename, 'Delete stock');

$stock = $pohoda->createStock([]);

$stock->addActionType('delete', [
    'code' => $code
]);

$pohoda->addItem($code, $stock);

$pohoda->close();
```
