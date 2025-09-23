<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Document;

use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Type;

abstract class AbstractHeader extends AbstractPart
{
    use Common\AddParameterTrait;

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // process partner identity
        if (isset($data['partnerIdentity'])) {
            $parentIdentity = new Type\Address($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
            $data['partnerIdentity'] = $parentIdentity->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data['partnerIdentity']);
        }

        // process my identity
        if (isset($data['myIdentity'])) {
            $myIdentity = new Type\MyAddress($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
            $data['myIdentity'] = $myIdentity->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data['myIdentity']);
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        if (is_null($this->namespace)) {
            throw new \LogicException('Namespace not set.');
        }

        if (is_null($this->nodePrefix)) {
            throw new \LogicException('Node name prefix not set.');
        }

        $xml = $this->createXML()->addChild($this->namespace . ':' . $this->nodePrefix . 'Header', '', $this->namespace($this->namespace));

        $this->addElements($xml, \array_merge($this->elements, ['parameters']), $this->namespace);

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);
    }
}
