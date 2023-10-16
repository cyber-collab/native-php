<?php

use App\Exception\EmptyStringException;
use App\Helper\FieldValidator;
use App\Helper\LetterSymbolsReverser;
use PHPUnit\Framework\TestCase;

class ReverserTest extends TestCase
{
    private object $validator;
    private object $objectReverse;

    protected function setUp(): void
    {
        $this->validator = $this->createMock(FieldValidator::class);
        $this->objectReverse = new LetterSymbolsReverser($this->validator);
    }

    public function testThrowException(): void
    {
        $emptyString = '';
        $this->validator->method("validateField")
            ->with($emptyString)
            ->willThrowException(new EmptyStringException('Field is empty, please enter data'));

        $this->expectException(EmptyStringException::class);
        $this->objectReverse->reverse($emptyString);
    }

    /**
     * @dataProvider reverseDataProvider
     */
    public function testObjectData(string|int $inputString, string $expectedResult): void
    {
        $this->assertSame(
            $expectedResult,
            $this->objectReverse->reverse($inputString),
            'All ok'
        );
    }

    public function reverseDataProvider(): iterable
    {
        return [
            ['d1cba hgf!e', 'a1bcd efg!h'],
            [123, '123']
        ];
    }
}
