<?php

namespace Riesenia\Pohoda\Common\OptionsResolver;

/**
 * Which methods are available to use for resolvers
 *
 * @see \Symfony\Component\OptionsResolver\OptionsResolver
 */
enum ActionsEnum: string
{
    case DEFAULT_VALUES = 'setDefault';
    case IS_REQUIRED = 'setRequired';
    //case DEFINED = 'setDefined'; // all known, not need
    //case DEPRECATED = 'setDeprecated'; // just shot the property class
    case NORMALIZER = 'setNormalizer';
    case ALLOWED_VALUES = 'setAllowedValues';
    case ALLOWED_TYPES = 'setAllowedTypes';
}
