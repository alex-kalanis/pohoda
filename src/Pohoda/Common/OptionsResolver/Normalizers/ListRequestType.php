<?php

namespace Riesenia\Pohoda\Common\OptionsResolver\Normalizers;

final class ListRequestType extends AbstractNormalizer
{
    public function normalize(mixed $options, mixed $value): string
    {
        // Addressbook is custom
        if ('Addressbook' == $value) {
            return 'AddressBook';
        }

        // IssueSlip is custom
        if ('IssueSlip' == $value) {
            return 'Vydejka';
        }

        // CashSlip is custom
        if ('CashSlip' == $value) {
            return 'Prodejka';
        }

        return \strval($value);
    }
}
