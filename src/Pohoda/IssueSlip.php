<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

use Riesenia\Pohoda\Type\Link;

class IssueSlip extends AbstractDocument
{
    public function getImportRoot(): string
    {
        return 'lst:vydejka';
    }

    /**
     * Add link.
     *
     * @param array<string,mixed> $data
     *
     * @return $this
     */
    public function addLink(array $data): self
    {
        if (!isset($this->data['links'])
            || !(
                is_array($this->data['links'])
                || (is_object($this->data['links']) && is_a($this->data['links'], \ArrayAccess::class))
            )
        ) {
            $this->data['links'] = [];
        }

        $link = new Link($this->dependenciesFactory);
        $this->data['links'][] = $link->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentElements(): array
    {
        return \array_merge(parent::getDocumentElements(), ['links']);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentNamespace(): string
    {
        return 'vyd';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentName(): string
    {
        return 'vydejka';
    }
}
