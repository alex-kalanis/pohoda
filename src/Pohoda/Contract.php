<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

/**
 * @property array{
 *     header: Contract\Desc,
 * } $data
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
    public function setData(array $data): parent
    {
        // pass to header
        $desc = new Contract\Desc($this->dependenciesFactory);
        $desc->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);
        $data = ['header' => $desc];

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('con:contract', '', $this->namespace('con'));
        $xml->addAttribute('version', '2.0');

        $this->addElements($xml, ['header'], 'con');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['header']);
    }
}
