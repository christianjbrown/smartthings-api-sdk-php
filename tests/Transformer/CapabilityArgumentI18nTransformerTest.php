<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityArgumentI18n;
use ChristianBrown\SmartThings\Transformer\CapabilityArgumentI18nTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityArgumentI18nTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

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
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new CapabilityArgumentI18nTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[CapabilityArgumentI18nTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
    }
}
