<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

/**
 * @property HeaderDto $data
 */
class Header extends AbstractAgenda
{
    use Common\AddParameterTrait;

    protected int $imagesCounter = 0;

    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // process intrastat
        if (isset($data->intrastat)) {
            $intrastat = new Intrastat($this->dependenciesFactory);
            $intrastat
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->intrastat);
            $data->intrastat = $intrastat;
        }

        // process recyclingContrib
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
     * Add image.
     *
     * @param string   $filepath
     * @param string   $description
     * @param int|null $order
     * @param bool     $default
     *
     * @return void
     */
    public function addImage(string $filepath, string $description = '', int $order = null, bool $default = false): void
    {
        $pictureDto = new PictureDto();
        $pictureDto->filepath = $filepath;
        $pictureDto->description = $description;
        $pictureDto->order = null === $order ? ++$this->imagesCounter : $order;
        $pictureDto->default = $default;

        $picture = new Picture($this->dependenciesFactory);
        $picture
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($pictureDto);
        $this->data->pictures[] = $picture;
    }

    /**
     * Add category.
     *
     * @param int $categoryId
     *
     * @return void
     */
    public function addCategory(int $categoryId): void
    {
        $categoryDto = new CategoryDto();
        $categoryDto->idCategory = $categoryId;

        $category = new Category($this->dependenciesFactory);
        $category
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($categoryDto);
        $this->data->categories[] = $category;
    }

    /**
     * Add int parameter.
     *
     * @param IntParameterDto $data
     *
     * @return void
     */
    public function addIntParameter(IntParameterDto $data): void
    {
        $intParameters = new IntParameter($this->dependenciesFactory);
        $intParameters
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data);
        $this->data->intParameters[] = $intParameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('stk:stockHeader', '', $this->namespace('stk'));

        $this->addElements($xml, $this->getDataElements(), 'stk');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new HeaderDto();
    }
}
