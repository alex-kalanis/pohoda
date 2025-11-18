<?php

declare(strict_types=1);

namespace spec\kalanis\Pohoda\ValueTransformer;

use PhpSpec\ObjectBehavior;
use kalanis\Pohoda\ValueTransformer\CyrillicTransliterationTransformer;

class CyrillicTransliterationTransformerSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CyrillicTransliterationTransformer::class);
    }

    public function it_transforms_cyrillic_characters(): void
    {
        $this->transform('Привет мир!')->shouldReturn('Privet mir!');
    }

    public function it_keeps_czech_characters(): void
    {
        $this->transform('Příliš žluťoučký kůň úpěl ďábelské ódy')->shouldReturn('Příliš žluťoučký kůň úpěl ďábelské ódy');
    }
}
