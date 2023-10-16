<?php

use App\Command\ReverseStringCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ReverseStringCommandTest extends TestCase
{
    protected object $application;
    public function setUp(): void
    {
        $this->application = new Application();
        $this->application->add(new ReverseStringCommand());
    }

    public function testExecuteString()
    {
        $command = $this->application->find('app:anagram');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            // pass arguments to the helper
            '--string' => 'acs',
        ]);
        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('sca', $output);
    }

    public function testExecuteFile()
    {
        $command = $this->application->find('app:anagram');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            // pass arguments to the helper
            '--file' => './files/string.txt',
        ]);
        $commandTester->assertCommandIsSuccessful();
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('cba', $output);
    }

    /** @dataProvider providedDataValues */
    public function testOption($input)
    {
        $mockObject = $this->createMock(ReverseStringCommand::class);
        $mockObject->expects($this->once())
            ->method('configure')
            ->willReturn($input);
        $this->assertSame($input, $mockObject->configure());
    }

    public function providedDataValues(): array
    {
        return [
            'asd' => ['--string'],
            '133' => ['--file']
        ];
    }
}
