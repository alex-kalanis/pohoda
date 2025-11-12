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
 * @property IssueSlip\IssueSlipDto $data
 */
class IssueSlip extends AbstractDocument
{
    public function getImportRoot(): string
    {
        return 'lst:vydejka';
    }

    /**
     * Add link.
     *
     * @param Type\Dtos\LinkDto $data
     *
     * @return $this
     */
    public function addLink(Type\Dtos\LinkDto $data): self
    {
        $link = new Type\Link($this->dependenciesFactory);
        $link
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data);
        $this->data->links[] = $link;

        return $this;
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

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new IssueSlip\IssueSlipDto();
    }
}
