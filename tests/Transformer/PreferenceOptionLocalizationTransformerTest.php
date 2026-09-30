<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\PreferenceOptionLocalization;
use ChristianBrown\SmartThings\Transformer\PreferenceOptionLocalizationTransformer;
use ChristianBrown\SmartThings\Transformer\PreferenceOptionLocalizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PreferenceOptionLocalization::class)]
#[CoversClass(PreferenceOptionLocalizationTransformer::class)]
final class PreferenceOptionLocalizationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PreferenceOptionLocalizationTransformerInterface::KEY_LABEL => 'test-label',
        ];

        $transformer = new PreferenceOptionLocalizationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-label', $actual->getLabel());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new PreferenceOptionLocalizationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[PreferenceOptionLocalizationTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
    }
}
