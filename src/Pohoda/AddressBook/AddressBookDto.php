<?php

namespace Riesenia\Pohoda\AddressBook;

use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Type;

class AddressBookDto extends Dtos\AbstractDto
{
    public Type\ActionType|Type\Dtos\ActionTypeDto|null $actionType = null;
    public Header|HeaderDto|null $header = null;
}
