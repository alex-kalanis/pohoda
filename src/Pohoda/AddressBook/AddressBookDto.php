<?php

namespace Riesenia\Pohoda\AddressBook;

use Riesenia\Pohoda\Common\Dtos;

class AddressBookDto extends Dtos\AbstractDto
{
    public Header|HeaderDto|null $header = null;
}
