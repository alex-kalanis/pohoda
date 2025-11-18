<?php

declare(strict_types=1);

namespace kalanis\Pohoda;

/**
 * @property Category\CategoryDto $data
 */
class Category extends AbstractAgenda
{
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
     * @param self|Category\CategoryDto $category
     *
     * @return $this
     */
    public function addSubcategory(self|Category\CategoryDto $category): self
    {
        $this->data->subCategories[] = $category;

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

        $this->addElements($category, $this->getDataElements(), 'ctg');

        if (!empty($this->data->subCategories)) {
            $subCategories = $category->addChild('ctg:subCategories', '', $this->namespace('ctg'));

            foreach ($this->data->subCategories as $subCategory) {
                if (\is_a($subCategory, self::class)) {
                    $subCategory->categoryXML($subCategories);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Category\CategoryDto();
    }
}
