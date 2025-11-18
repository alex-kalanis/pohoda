<?php

namespace kalanis\Pohoda\AddressBook;

use kalanis\Pohoda\Common\Dtos;
use kalanis\Pohoda\Type;

class AddressBookDto extends Dtos\AbstractDto
{
    public Type\ActionType|Type\Dtos\ActionTypeDto|null $actionType = null;
    public Header|HeaderDto|null $header = null;
}
