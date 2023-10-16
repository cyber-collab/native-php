<?php

namespace App\Helper;

use App\Exception\EmptyStringException;

class LetterSymbolsReverser
{
    private const LETTERS = "/^[a-zA-Z\s]+$/";
    private FieldValidator $validator;

    public function __construct(FieldValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @throws EmptyStringException
     */
    public function reverse(string $inputString): string
    {
        $this->validator->validateField($inputString);
        $words = explode(' ', $inputString);
        foreach ($words as $key => $word) {
            [$letterChars, $othersSymbols] = $this->separation($word);
            $words[$key] = $this->sort($letterChars, $othersSymbols);
        }
        return implode(' ', $words);
    }

    private function separation(string $inputString): array
    {
        $inputString = str_split($inputString);
        $letterChars = [];
        $othersSymbols = [];
        foreach ($inputString as $key => $char) {
            if (preg_match(self::LETTERS, $char)) {
                $letterChars[$key] = $char;
            } else {
                $othersSymbols[$key] = $char;
            }
        }
        return [$letterChars, $othersSymbols];
    }

    private function sort(array $letterChars, array $othersSymbols): string
    {
        $keys = array_keys($letterChars);
        $letterChars = array_reverse($letterChars);
        $letterChars = array_combine($keys, $letterChars);
        $inputString = $othersSymbols + $letterChars;
        ksort($inputString);
        return implode('', $inputString);
    }
}
