<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\OptionsResolver;

class Category extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $category = $this->data['idCategory'] ?? null;
        return $this->createXML()->addChild(
            'stk:idCategory',
            is_null($category) ? null : strval($category),
            $this->namespace('stk')
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['idCategory']);

        // validate / format options
        $resolver->setRequired('idCategory');
        $resolver->setNormalizer('idCategory', $resolver->getNormalizer('int'));
    }
}
