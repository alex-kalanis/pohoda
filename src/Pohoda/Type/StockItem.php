<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Type;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\DI\DependenciesFactory;

class StockItem extends AbstractAgenda
{
    use Common\SetNamespaceTrait;

    public function __construct(
        DependenciesFactory $dependenciesFactory,
    ) {
        // init attributes
        $this->elementsAttributesMapper = [
            'insertAttachStock' => new Common\ElementAttributes('stockItem', 'insertAttachStock'),
            'applyUserSettingsFilterOnTheStore' => new Common\ElementAttributes('stockItem', 'applyUserSettingsFilterOnTheStore'),
        ];

        parent::__construct($dependenciesFactory);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\StockItemDto();
    }
}
