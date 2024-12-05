<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\PrintRequest;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\OptionsResolver;

class Parameters extends AbstractAgenda
{
    /** @var string[] */
    protected array $elements = ['copy', 'datePrint', 'checkbox1', 'checkbox2', 'checkbox3', 'checkbox4', 'checkbox5', 'checkbox6', 'checkbox7', 'radioButton1', 'spin1', 'currency1', 'month1', 'month2', 'year1', 'date1', 'date2', 'date3', 'date4', 'text1', 'text2', 'text3', 'combobox1', 'combobox2', 'combobox3', 'comboboxEx1', 'comboboxEx2'];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $data, string $ico, bool $resolveOptions = true)
    {
        // process checkbox1
        if (isset($data['checkbox1'])) {
            $data['checkbox1'] = new Checkbox1($data['checkbox1'], $ico, $resolveOptions);
        }
        // process checkbox2
        if (isset($data['checkbox2'])) {
          $data['checkbox2'] = new Checkbox2($data['checkbox2'], $ico, $resolveOptions);
        }
        // process checkbox3
        if (isset($data['checkbox3'])) {
          $data['checkbox3'] = new Checkbox3($data['checkbox3'], $ico, $resolveOptions);
        }
        // process checkbox4
        if (isset($data['checkbox4'])) {
          $data['checkbox4'] = new Checkbox4($data['checkbox4'], $ico, $resolveOptions);
        }
        // process checkbox5
        if (isset($data['checkbox5'])) {
          $data['checkbox5'] = new Checkbox5($data['checkbox5'], $ico, $resolveOptions);
        }
        // process checkbox6
        if (isset($data['checkbox6'])) {
          $data['checkbox6'] = new Checkbox6($data['checkbox6'], $ico, $resolveOptions);
        }
        // process checkbox7
        if (isset($data['checkbox7'])) {
          $data['checkbox7'] = new Checkbox7($data['checkbox7'], $ico, $resolveOptions);
        }
        // process radioButton1
        if (isset($data['radioButton1'])) {
          $data['radioButton1'] = new RadioButton1($data['radioButton1'], $ico, $resolveOptions);
        }
        // process spin1
        if (isset($data['spin1'])) {
          $data['spin1'] = new Spin1($data['spin1'], $ico, $resolveOptions);
        }
        // process currency1
        if (isset($data['currency1'])) {
          $data['currency1'] = new Currency1($data['currency1'], $ico, $resolveOptions);
        }
        // process month1
        if (isset($data['month1'])) {
          $data['month1'] = new Month1($data['month1'], $ico, $resolveOptions);
        }
        // process month2
        if (isset($data['month2'])) {
          $data['month2'] = new Month2($data['month2'], $ico, $resolveOptions);
        }
        // process year1
        if (isset($data['year1'])) {
          $data['year1'] = new Year1($data['year1'], $ico, $resolveOptions);
        }
        // process date1
        if (isset($data['date1'])) {
          $data['date1'] = new Date1($data['date1'], $ico, $resolveOptions);
        }
        // process date2
        if (isset($data['date2'])) {
          $data['date2'] = new Date2($data['date2'], $ico, $resolveOptions);
        }
        // process date3
        if (isset($data['date3'])) {
          $data['date3'] = new Date3($data['date3'], $ico, $resolveOptions);
        }
        // process date4
        if (isset($data['date4'])) {
          $data['date4'] = new Date4($data['date4'], $ico, $resolveOptions);
        }
        // process text1
        if (isset($data['text1'])) {
          $data['text1'] = new Text1($data['text1'], $ico, $resolveOptions);
        }
        // process text2
        if (isset($data['text2'])) {
          $data['text2'] = new Text2($data['text2'], $ico, $resolveOptions);
        }
        // process text3
        if (isset($data['text3'])) {
          $data['text3'] = new Text3($data['text3'], $ico, $resolveOptions);
        }
        // process combobox1
        if (isset($data['combobox1'])) {
          $data['combobox1'] = new Combobox1($data['combobox1'], $ico, $resolveOptions);
        }
        // process combobox2
        if (isset($data['combobox2'])) {
          $data['combobox2'] = new Combobox2($data['combobox2'], $ico, $resolveOptions);
        }
        // process combobox3
        if (isset($data['combobox3'])) {
          $data['combobox3'] = new Combobox3($data['combobox3'], $ico, $resolveOptions);
        }
        // process comboboxEx1
        if (isset($data['comboboxEx1'])) {
          $data['comboboxEx1'] = new ComboboxEx1($data['comboboxEx1'], $ico, $resolveOptions);
        }
        // process comboboxEx2
        if (isset($data['comboboxEx2'])) {
          $data['comboboxEx2'] = new ComboboxEx2($data['comboboxEx2'], $ico, $resolveOptions);
        }

        parent::__construct($data, $ico, $resolveOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('prn:parameters', '', $this->namespace('prn'));

        $this->addElements($xml, $this->elements, 'prn');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        $resolver->setNormalizer('copy', $resolver->getNormalizer('int'));
        $resolver->setNormalizer('datePrint', $resolver->getNormalizer('string'));
    }
}
