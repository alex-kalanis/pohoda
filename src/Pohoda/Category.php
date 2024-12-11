<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

use Riesenia\Pohoda\Common\OptionsResolver;

class Category extends AbstractAgenda
{

    /** @var string[] */
    protected array $elements = ['name', 'description', 'sequence', 'displayed', 'picture', 'note'];

    public function getImportRoot(): string
    {
        return 'ctg:category';
    }

    public function canImportRecursive(): bool
    {
        return true;
    }

    /**
     * Add subcategory.
     *
     * @param self $category
     *
     * @return $this
     */
    public function addSubcategory(self $category): self
    {
        if (!isset($this->data['subCategories'])
            || !(
                is_array($this->data['subCategories'])
                || (is_object($this->data['subCategories']) && is_a($this->data['subCategories'], \ArrayAccess::class))
            )
        ) {
            $this->data['subCategories'] = [];
        }

        $this->data['subCategories'][] = $category;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('ctg:categoryDetail', '', $this->namespace('ctg'));
        $xml->addAttribute('version', '2.0');

        $this->categoryXML($xml);

        return $xml;
    }

    /**
     * Attach category to XML element.
     *
     * @param \SimpleXMLElement $xml
     *
     * @return void
     */
    public function categoryXML(\SimpleXMLElement $xml)
    {
        $category = $xml->addChild('ctg:category', '', $this->namespace('ctg'));

        $this->addElements($category, $this->elements, 'ctg');

        if (isset($this->data['subCategories']) && is_iterable($this->data['subCategories'])) {
            $subCategories = $category->addChild('ctg:subCategories', '', $this->namespace('ctg'));

            foreach ($this->data['subCategories'] as $subCategory) {
                /** @var self $subCategory */
                $subCategory->categoryXML($subCategories);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setRequired('name');
        $resolver->setNormalizer('name', $this->normalizerFactory->getClosure('string48'));
        $resolver->setNormalizer('sequence', $this->normalizerFactory->getClosure('int'));
        $resolver->setNormalizer('displayed', $this->normalizerFactory->getClosure('bool'));
    }
}
