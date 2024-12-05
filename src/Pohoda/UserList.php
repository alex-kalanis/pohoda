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
use Riesenia\Pohoda\UserList\ItemUserCode;

class UserList extends AbstractAgenda
{

    public static string $importRoot = 'lst:listUserCode';

    /**
     * Add item user code.
     *
     * @param array<string,mixed> $data
     *
     * @return $this
     */
    public function addItemUserCode(array $data): self
    {
        if (!isset($this->data['itemUserCodes'])
            || !(
                is_array($this->data['itemUserCodes'])
                || (is_object($this->data['itemUserCodes']) && is_a($this->data['itemUserCodes'], \ArrayAccess::class))
            )
        ) {
            $this->data['itemUserCodes'] = [];
        }

        $this->data['itemUserCodes'][] = new ItemUserCode($data, $this->ico);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('lst:listUserCode', '', $this->namespace('lst'));
        $xml->addAttribute('version', '1.1');
        $xml->addAttribute('code', strval($this->data['code']));
        $xml->addAttribute('name', strval($this->data['name']));

        if (isset($this->data['constants']) && 'true' == $this->data['constants']) {
            $xml->addAttribute('constants', strval($this->data['constants']));
        }

        if (isset($this->data['itemUserCodes']) && is_iterable($this->data['itemUserCodes'])) {
            foreach ($this->data['itemUserCodes'] as $itemUserCode) {
                /** @var ItemUserCode $itemUserCode */
                $this->appendNode($xml, $itemUserCode->getXML());
            }
        }

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['code', 'name', 'constants']);

        // validate / format options
        $resolver->setRequired('code');
        $resolver->setRequired('name');
        $resolver->setNormalizer('constants', $resolver->getNormalizer('bool'));
    }
}
