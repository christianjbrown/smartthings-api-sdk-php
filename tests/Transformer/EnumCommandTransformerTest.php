<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\EnumCommand;
use ChristianBrown\SmartThings\Transformer\EnumCommandTransformer;
use ChristianBrown\SmartThings\Transformer\EnumCommandTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(EnumCommand::class)]
#[CoversClass(EnumCommandTransformer::class)]
final class EnumCommandTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            EnumCommandTransformerInterface::KEY_COMMAND => 'test-command',
            EnumCommandTransformerInterface::KEY_VALUE => 'test-value',
        ];

        $transformer = new EnumCommandTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-command', $actual->getCommand());
        self::assertSame('test-value', $actual->getValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new EnumCommandTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'commandAbsent' => [[EnumCommandTransformerInterface::KEY_VALUE => 'test-value'], sprintf(EnumCommandTransformerInterface::UNEXPECTED_STRING_SPRINTF, EnumCommandTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[EnumCommandTransformerInterface::KEY_VALUE => 'test-value', EnumCommandTransformerInterface::KEY_COMMAND => 42], sprintf(EnumCommandTransformerInterface::UNEXPECTED_STRING_SPRINTF, EnumCommandTransformerInterface::KEY_COMMAND)];
        yield 'valueAbsent' => [[EnumCommandTransformerInterface::KEY_COMMAND => 'test-command'], sprintf(EnumCommandTransformerInterface::UNEXPECTED_STRING_SPRINTF, EnumCommandTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[EnumCommandTransformerInterface::KEY_COMMAND => 'test-command', EnumCommandTransformerInterface::KEY_VALUE => 42], sprintf(EnumCommandTransformerInterface::UNEXPECTED_STRING_SPRINTF, EnumCommandTransformerInterface::KEY_VALUE)];
    }
}
