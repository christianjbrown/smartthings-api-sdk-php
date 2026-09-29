<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\IconImage;
use ChristianBrown\SmartThings\Transformer\IconImageTransformer;
use ChristianBrown\SmartThings\Transformer\IconImageTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(IconImage::class)]
#[CoversClass(IconImageTransformer::class)]
final class IconImageTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            IconImageTransformerInterface::KEY_URL => 'test-url',
        ];

        $transformer = new IconImageTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-url', $actual->getUrl());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new IconImageTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'urlAbsent' => [[], 'getUrl', null];
        yield 'urlWrongType' => [[IconImageTransformerInterface::KEY_URL => 42], 'getUrl', null];
        yield 'urlValid' => [[IconImageTransformerInterface::KEY_URL => 'test-url'], 'getUrl', 'test-url'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new IconImageTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getUrl());
    }
}
