<?php

namespace kalanis\Pohoda\Category;

use kalanis\Pohoda\Category;
use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos;

class CategoryDto extends Dtos\AbstractDto
{
    #[Attributes\Options\StringOption(48), Attributes\Options\RequiredOption]
    public ?string $name = null;
    public ?string $description = null;
    #[Attributes\Options\IntegerOption]
    public int|string|null $sequence = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $displayed = null;
    public ?string $picture = null;
    public ?string $note = null;
    /** @var array<self|Category> */
    #[Attributes\OnlyInternal]
    public array $subCategories = [];
}
