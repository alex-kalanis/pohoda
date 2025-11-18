<?php

namespace kalanis\Pohoda\PrintRequest;

class ParameterInstances
{
    /** @var array<string, class-string<Parameter>> */
    protected array $instances = [
        'checkbox1' => Checkbox1::class,
        'checkbox2' => Checkbox2::class,
        'checkbox3' => Checkbox3::class,
        'checkbox4' => Checkbox4::class,
        'checkbox5' => Checkbox5::class,
        'checkbox6' => Checkbox6::class,
        'checkbox7' => Checkbox7::class,
        'checkbox8' => Checkbox8::class,
        'radioButton1' => RadioButton1::class,
        'spin1' => Spin1::class,
        'currency1' => Currency1::class,
        'month1' => Month1::class,
        'month2' => Month2::class,
        'year1' => Year1::class,
        'date1' => Date1::class,
        'date2' => Date2::class,
        'date3' => Date3::class,
        'date4' => Date4::class,
        'text1' => Text1::class,
        'text2' => Text2::class,
        'text3' => Text3::class,
        'combobox1' => Combobox1::class,
        'combobox2' => Combobox2::class,
        'combobox3' => Combobox3::class,
        'comboboxEx1' => ComboboxEx1::class,
        'comboboxEx2' => ComboboxEx2::class,
    ];

    /**
     * @param string $key
     * @return class-string<Parameter>
     */
    public function getByKey(string $key): string
    {
        if (!isset($this->instances[$key])) {
            throw new \DomainException(sprintf('The key *%s* is not known.', $key));
        }
        return $this->instances[$key];
    }

    /**
     * @return string[]
     */
    public function getKeys(): array
    {
        return array_keys($this->instances);
    }
}
