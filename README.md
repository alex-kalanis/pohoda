# Pohoda XML

![Build Status](https://github.com/alex-kalanis/pohoda/actions/workflows/test.yml/badge.svg)
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

$partnerIdentityAddress = new Pohoda\Type\Dtos\AddressTypeDto();
$partnerIdentityAddress->name = $billing_name;
$partnerIdentityAddress->street => $billing_street;
$partnerIdentityAddress->city => $billing_city;
$partnerIdentityAddress->zip => $billing_zip;
$partnerIdentityAddress->email => $email;
$partnerIdentityAddress->phone => $phone;

$partnerIdentityAddress = new Pohoda\Type\Dtos\ShipToAddressDto();
$partnerIdentityAddress->name = $shipping_name;
$partnerIdentityAddress->street => $shipping_street;
$partnerIdentityAddress->city => $shipping_city;
$partnerIdentityAddress->zip => $shipping_zip;
$partnerIdentityAddress->email => $email;
$partnerIdentityAddress->phone => $phone;

$partnerIdentity = new Pohoda\Type\Dtos\AddressDto();
$partnerIdentity->address = $partnerIdentityAddress;
$partnerIdentity->shipToAddress = $partnerIdentityAddress;

$orderHeaderDto = new Pohoda\Order\HeaderDto();
$orderHeaderDto->numberOrder = $order_number;
$orderHeaderDto->isReserved = true;
$orderHeaderDto->date = $created;
$orderHeaderDto->text = '...';
$orderHeaderDto->partnerIdentity = $partnerIdentity;

$orderDto = new Pohoda\Order\OrderDto();
$orderDto->header = $orderHeaderDto;

// create order
$order = $pohoda->createOrder($orderDto);

// add items
foreach ($items as $item) {

    $homeCurrency = new Pohoda\Type\Dtos\CurrencyItemDto();
    $homeCurrency->unitPrice = $item->unit_price;
    
    $stockItem = new Pohoda\Type\Dtos\StockItemDto();
    $stockItem->stockItem = [
        'id' => $item->pohoda_id
    ];

    $itemDto = new Pohoda\Order\ItemDto();
    $itemDto->code => $item->code;
    $itemDto->text => $item->text;
    $itemDto->quantity => $item->quantity;
    $itemDto->payVAT => false;
    $itemDto->rateVAT => $item->rate;
    $itemDto->homeCurrency = $homeCurrency;
    $itemDto->stockItem = $stockItem;

    $order->addItem($itemDto);
}

// add summary
$summaryDto = new Riesenia\Pohoda\Order\SummaryDto();
$summaryDto->roundingDocument = 'none';
$order->addSummary($summaryDto);

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

$requestDto = new Pohoda\ListRequest\ListRequestDto();
$requestDto->type = 'Stock';

$request = $pohoda->createListRequest($requestDto);

// optional filter
$request->addUserFilterName(
    Pohoda\ListRequest\UserFilterNameDto::init('MyFilter')
);
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

## Example of deleting stock

When you delete stock you need to create an agenda with empty data and set them *delete* actionType.

```php
use Riesenia\Pohoda;

$pohoda = new Pohoda('ICO');

// create request for deletion
$pohoda->open($filename, 'd_zas1', 'Delete stock');

$stock = $pohoda->createStock(null);

$stock->addActionType('delete', [
    'code' => $code
]);

$pohoda->addItem($code, $stock);

$pohoda->close();
```

## Using *ValueTransformer* for value update

With interface *ValueTransformer* you can implement the transformation, which changes all the values. Example for change all values to uppercase:

```php
use Riesenia\Pohoda;

class Capitalizer implements \Riesenia\Pohoda\ValueTransformer\ValueTransformerInterface
{
    public function transform(string $value): string
    {
        return \strtoupper($value);
    }
}

$pohoda = new Pohoda('ICO');

// Register the capitalizer to be used to capitalize values
$pohoda->getTransformerListing()->addTransformer(new Capitalizer());

...
```

## Sources

* [XML Import](https://www.stormware.cz/pohoda/xml/dokladyimport/)
* [XML Export](https://www.stormware.cz/pohoda/xml/dokladyexport/)
* [Schemas](https://www.stormware.cz/pohoda/xml/seznamschemat/)
* [Checker](https://www.stormware.cz/pohoda/xml/xmlvalidator/) - Win 32bit
