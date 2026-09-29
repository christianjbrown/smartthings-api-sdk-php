<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ViperAppLinks;
use ChristianBrown\SmartThings\Transformer\ViperAppLinksTransformer;
use ChristianBrown\SmartThings\Transformer\ViperAppLinksTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ViperAppLinks::class)]
#[CoversClass(ViperAppLinksTransformer::class)]
final class ViperAppLinksTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ViperAppLinksTransformerInterface::KEY_ANDROID => 'test-android',
            ViperAppLinksTransformerInterface::KEY_IOS => 'test-ios',
            ViperAppLinksTransformerInterface::KEY_IS_LINKING_ENABLED => true,
        ];

        $transformer = new ViperAppLinksTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-android', $actual->getAndroid());
        self::assertSame('test-ios', $actual->getIos());
        self::assertTrue($actual->getIsLinkingEnabled());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ViperAppLinksTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'androidAbsent' => [[], 'getAndroid', null];
        yield 'androidWrongType' => [[ViperAppLinksTransformerInterface::KEY_ANDROID => 42], 'getAndroid', null];
        yield 'androidValid' => [[ViperAppLinksTransformerInterface::KEY_ANDROID => 'test-android'], 'getAndroid', 'test-android'];
        yield 'iosAbsent' => [[], 'getIos', null];
        yield 'iosWrongType' => [[ViperAppLinksTransformerInterface::KEY_IOS => 42], 'getIos', null];
        yield 'iosValid' => [[ViperAppLinksTransformerInterface::KEY_IOS => 'test-ios'], 'getIos', 'test-ios'];
        yield 'isLinkingEnabledAbsent' => [[], 'getIsLinkingEnabled', null];
        yield 'isLinkingEnabledWrongType' => [[ViperAppLinksTransformerInterface::KEY_IS_LINKING_ENABLED => 'not-bool'], 'getIsLinkingEnabled', null];
        yield 'isLinkingEnabledValid' => [[ViperAppLinksTransformerInterface::KEY_IS_LINKING_ENABLED => true], 'getIsLinkingEnabled', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new ViperAppLinksTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getAndroid());
        self::assertNull($actual->getIos());
        self::assertNull($actual->getIsLinkingEnabled());
    }
}
