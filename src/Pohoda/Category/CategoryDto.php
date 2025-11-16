<?php

namespace Riesenia\Pohoda\Category;

use Riesenia\Pohoda\Category;
use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos;

class CategoryDto extends Dtos\AbstractDto
{
    public ?string $name = null;
    public ?string $description = null;
    public int|string|null $sequence = null;
    public bool|string|null $displayed = null;
    public ?string $picture = null;
    public ?string $note = null;
    /** @var array<self|Category> */
    #[Attributes\OnlyInternal]
    public array $subCategories = [];
}
