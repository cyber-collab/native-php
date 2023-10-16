<?php

use App\Exception\EmptyStringException;
use App\Helper\FieldValidator;
use PHPUnit\Framework\TestCase;

class ValidatorFieldTest extends TestCase
{
    protected object $validateField;

    public function testEmptyField(): void
    {
        $this->validateField = $this->createMock(FieldValidator::class);

        $emptyField = '';
        $this->validateField->method("validateField")
            ->with($emptyField)
            ->willThrowException(new EmptyStringException('Field is empty, please enter data'));

        $this->expectException(EmptyStringException::class);
        $this->validateField->validateField($emptyField);
    }
}
