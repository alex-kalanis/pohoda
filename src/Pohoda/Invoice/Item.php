<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Invoice;

use kalanis\Pohoda\Common;
use kalanis\Pohoda\Document\AbstractItem;
use kalanis\Pohoda\Type\RecyclingContrib;

class Item extends AbstractItem
{
    /**
     * @inheritdoc
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        if (isset($data->recyclingContrib)) {
            $recyclingContrib = new RecyclingContrib($this->dependenciesFactory);
            $recyclingContrib
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->recyclingContrib);
            $data->recyclingContrib = $recyclingContrib;
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new ItemDto();
    }
}
