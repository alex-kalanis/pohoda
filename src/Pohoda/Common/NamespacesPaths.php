<?php

namespace Riesenia\Pohoda\Common;


class NamespacesPaths
{
    /** @var array<string,string> */
    public static array $namespaces = [
        'adb' => 'http://www.stormware.cz/schema/version_2/addressbook.xsd',
        'bnk' => 'http://www.stormware.cz/schema/version_2/bank.xsd',
        'con' => 'http://www.stormware.cz/schema/version_2/contract.xsd',
        'ctg' => 'http://www.stormware.cz/schema/version_2/category.xsd',
        'dat' => 'http://www.stormware.cz/schema/version_2/data.xsd',
        'ftr' => 'http://www.stormware.cz/schema/version_2/filter.xsd',
        'int' => 'http://www.stormware.cz/schema/version_2/intDoc.xsd',
        'inv' => 'http://www.stormware.cz/schema/version_2/invoice.xsd',
        'ipm' => 'http://www.stormware.cz/schema/version_2/intParam.xsd',
        'lAdb' => 'http://www.stormware.cz/schema/version_2/list_addBook.xsd',
        'lst' => 'http://www.stormware.cz/schema/version_2/list.xsd',
        'lStk' => 'http://www.stormware.cz/schema/version_2/list_stock.xsd',
        'ofr' => 'http://www.stormware.cz/schema/version_2/offer.xsd',
        'ord' => 'http://www.stormware.cz/schema/version_2/order.xsd',
        'pre' => 'http://www.stormware.cz/schema/version_2/prevodka.xsd',
        'pri' => 'http://www.stormware.cz/schema/version_2/prijemka.xsd',
        'prn' => 'http://www.stormware.cz/schema/version_2/print.xsd',
        'pro' => 'http://www.stormware.cz/schema/version_2/prodejka.xsd',
        'str' => 'http://www.stormware.cz/schema/version_2/storage.xsd',
        'stk' => 'http://www.stormware.cz/schema/version_2/stock.xsd',
        'sup' => 'http://www.stormware.cz/schema/version_2/supplier.xsd',
        'typ' => 'http://www.stormware.cz/schema/version_2/type.xsd',
        'vch' => 'http://www.stormware.cz/schema/version_2/voucher.xsd',
        'vyd' => 'http://www.stormware.cz/schema/version_2/vydejka.xsd',

        'rsp' => "http://www.stormware.cz/schema/version_2/response.xsd",
        'rdc' => "http://www.stormware.cz/schema/version_2/documentresponse.xsd",
        'lCen' => "http://www.stormware.cz/schema/version_2/list_centre.xsd",
        'lAcv' => "http://www.stormware.cz/schema/version_2/list_activity.xsd",
        'acu' => "http://www.stormware.cz/schema/version_2/accountingunit.xsd",
        'enq' => "http://www.stormware.cz/schema/version_2/enquiry.xsd",
        'bal' => "http://www.stormware.cz/schema/version_2/balance.xsd",
        'vyr' => "http://www.stormware.cz/schema/version_2/vyroba.xsd",
        'prm' => "http://www.stormware.cz/schema/version_2/parameter.xsd",
        'lCon' => "http://www.stormware.cz/schema/version_2/list_contract.xsd",
        'idp' => "http://www.stormware.cz/schema/version_2/individualPrice.xsd",
        'lck' => "http://www.stormware.cz/schema/version_2/lock.xsd",
        'isd' => "http://www.stormware.cz/schema/version_2/isdoc.xsd",
        'sEET' => "http://www.stormware.cz/schema/version_2/sendEET.xsd",
        'act' => "http://www.stormware.cz/schema/version_2/accountancy.xsd",
        'sto' => "http://www.stormware.cz/schema/version_2/store.xsd",
        'grs' => "http://www.stormware.cz/schema/version_2/groupStocks.xsd",
        'acp' => "http://www.stormware.cz/schema/version_2/actionPrice.xsd",
        'csh' => "http://www.stormware.cz/schema/version_2/cashRegister.xsd",
        'bka' => "http://www.stormware.cz/schema/version_2/bankAccount.xsd",
        'ilt' => "http://www.stormware.cz/schema/version_2/inventoryLists.xsd",
        'nms' => "http://www.stormware.cz/schema/version_2/numericalSeries.xsd",
        'pay' => "http://www.stormware.cz/schema/version_2/payment.xsd",
        'mKasa' => "http://www.stormware.cz/schema/version_2/mKasa.xsd",
        'gdp' => "http://www.stormware.cz/schema/version_2/GDPR.xsd",
        'est' => "http://www.stormware.cz/schema/version_2/establishment.xsd",
        'cen' => "http://www.stormware.cz/schema/version_2/centre.xsd",
        'acv' => "http://www.stormware.cz/schema/version_2/activity.xsd",
        'afp' => "http://www.stormware.cz/schema/version_2/accountingFormOfPayment.xsd",
        'vat' => "http://www.stormware.cz/schema/version_2/classificationVAT.xsd",
        'rgn' => "http://www.stormware.cz/schema/version_2/registrationNumber.xsd",
        'asv' => "http://www.stormware.cz/schema/version_2/accountingSalesVouchers.xsd",
        'arch' => "http://www.stormware.cz/schema/version_2/archive.xsd",
        'req' => "http://www.stormware.cz/schema/version_2/productRequirement.xsd",
        'mov' => "http://www.stormware.cz/schema/version_2/movement.xsd",
        'rec' => "http://www.stormware.cz/schema/version_2/recyclingContrib.xsd",
        'srv' => "http://www.stormware.cz/schema/version_2/service.xsd",
        'rul' => "http://www.stormware.cz/schema/version_2/rulesPairing.xsd",
        'lwl' => "http://www.stormware.cz/schema/version_2/liquidationWithoutLink.xsd",
        'dis' => "http://www.stormware.cz/schema/version_2/discount.xsd",
        'lqd' => "http://www.stormware.cz/schema/version_2/automaticLiquidation.xsd",
        'uag' => "http://www.stormware.cz/schema/version_2/userAgenda.xsd",
        'apf' => "http://www.stormware.cz/schema/version_2/advancePartFulfilment.xsd",
    ];


    /**
     * Get namespace.
     *
     * @param string $short
     *
     * @return string
     */
    public function namespace(string $short): string
    {
        if (!isset(self::$namespaces[$short])) {
            throw new \OutOfRangeException('Invalid namespace.');
        }

        return self::$namespaces[$short];
    }

    /**
     * @return array<string, string>
     */
    public function allNamespaces(): array
    {
        return self::$namespaces;
    }
}
