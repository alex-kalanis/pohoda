<?php

declare(strict_types=1);

namespace kalanis\Pohoda;

/**
 * @property Contract\ContractDto $data
 */
class Contract extends AbstractAgenda
{
    use Common\AddParameterToHeaderTrait;

    public function getImportRoot(): string
    {
        return 'lCon:contract';
    }

    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // pass to header
        $desc = new Contract\Desc($this->dependenciesFactory);
        $desc
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data);
        $dto = new Contract\ContractDto();
        $dto->header = $desc;

        return parent::setData($dto);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('con:contract', '', $this->namespace('con'));
        $xml->addAttribute('version', '2.0');

        $this->addElements($xml, $this->getDataElements(), 'con');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Contract\ContractDto();
    }
}
