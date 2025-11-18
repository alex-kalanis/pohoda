<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Bank;

use kalanis\Pohoda\Common;
use kalanis\Pohoda\Document\AbstractHeader;

class Header extends AbstractHeader
{
    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // process report
        if (isset($data->statementNumber)) {
            $statementNumber = new StatementNumber($this->dependenciesFactory);
            $statementNumber
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->statementNumber);
            $data->statementNumber = $statementNumber;
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new HeaderDto();
    }
}
