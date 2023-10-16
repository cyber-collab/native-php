<?php

namespace App\Helper;

use App\Exception\EmptyStringException;

class FieldValidator
{
    /**
     * @throws EmptyStringException
     */
    public function validateField(string $field): void
    {
        if (empty($field)) {
            throw new EmptyStringException('Field is empty, please enter data');
        }
    }
}
