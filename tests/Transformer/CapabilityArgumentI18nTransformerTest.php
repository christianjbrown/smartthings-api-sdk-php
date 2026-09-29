<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityArgumentI18n;
use ChristianBrown\SmartThings\Transformer\CapabilityArgumentI18nTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityArgumentI18nTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(CapabilityArgumentI18n::class)]
#[CoversClass(CapabilityArgumentI18nTransformer::class)]
final class CapabilityArgumentI18nTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CapabilityArgumentI18nTransformerInterface::KEY_LABEL => 'test-label',
        ];

        $transformer = new CapabilityArgumentI18nTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-label', $actual->getLabel());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new CapabilityArgumentI18nTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'labelAbsent' => [[], sprintf(CapabilityArgumentI18nTransformerInterface::UNEXPECTED_STRING_SPRINTF, CapabilityArgumentI18nTransformerInterface::KEY_LABEL)];
        yield 'labelWrongType' => [[CapabilityArgumentI18nTransformerInterface::KEY_LABEL => 42], sprintf(CapabilityArgumentI18nTransformerInterface::UNEXPECTED_STRING_SPRINTF, CapabilityArgumentI18nTransformerInterface::KEY_LABEL)];
    }
}
