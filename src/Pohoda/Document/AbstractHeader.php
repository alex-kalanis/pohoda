<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Document;

use kalanis\Pohoda\Common;
use kalanis\Pohoda\Type;

/**
 * @property Common\Dtos\AbstractHeaderDto $data
 */
abstract class AbstractHeader extends AbstractPart
{
    use Common\AddParameterTrait;

    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // process partner identity
        if (isset($data->partnerIdentity)) {
            $parentIdentity = new Type\Address($this->dependenciesFactory);
            $parentIdentity
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->partnerIdentity);
            $data->partnerIdentity = $parentIdentity;
        }

        // process my identity
        if (isset($data->myIdentity)) {
            $myIdentity = new Type\MyAddress($this->dependenciesFactory);
            $myIdentity
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->myIdentity);
            $data->myIdentity = $myIdentity;
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

        $this->addElements($xml, $this->getDataElements(), $this->namespace);

        return $xml;
    }
}
