<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Type;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;
use kalanis\Pohoda\DI\DependenciesFactory;

class CurrencyHome extends AbstractAgenda
{
    use Common\SetNamespaceTrait;

    public function __construct(
        DependenciesFactory $dependenciesFactory,
    ) {
        // init attributes
        $this->elementsAttributesMapper = [
            'priceLowVatRate' => new Common\ElementAttributes('priceLowVAT', 'rate'),
            'priceHighVatRate' => new Common\ElementAttributes('priceHighVAT', 'rate'),
        ];

        parent::__construct($dependenciesFactory);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\CurrencyHomeDto();
    }
}
