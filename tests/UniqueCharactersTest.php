<?php

use PHPUnit\Framework\TestCase;
use App\Helper\UniqueCharacters;

class UniqueCharactersTest extends TestCase
{
    private object $object;

    protected function setUp(): void
    {
        $arrayWords = str_split('abbc');
        $this->object = new UniqueCharacters($arrayWords);
    }

    /**
     * @dataProvider numberUniqueCharactersDataProvider
     */
    public function testObjectData(int $arrayWords, int $expectedResult): void
    {
        $this->assertSame($this->object->numberUniqueCharacters(), $expectedResult, 'All ok');
    }

    public function numberUniqueCharactersDataProvider(): iterable
    {
        return [
            'correct result' => [2,2]
        ];
    }

    public function testExpectActual()
    {
        $this->expectOutputString('2');
        print $this->object->numberUniqueCharacters();
    }
}
