<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Common;

use Closure;
use Symfony\Component\OptionsResolver\OptionsResolver as SymfonyOptionsResolver;

class OptionsResolver extends SymfonyOptionsResolver
{
    protected readonly OptionsResolver\Normalizers\NormalizerFactory $normalizerFactory;

    public function __construct()
    {
        $this->normalizerFactory = new OptionsResolver\Normalizers\NormalizerFactory();
    }

    /**
     * Get normalizer.
     *
     * @param string $type
     *
     * @return Closure
     */
    public function getNormalizer(string $type): Closure
    {
        return $this->normalizerFactory->getNormalizer($type)->normalize(...);
    }
}
