<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityArgumentI18nInterface;
use ChristianBrown\SmartThings\Model\CapabilityArgumentLocalization;
use ChristianBrown\SmartThings\Transformer\CapabilityArgumentI18nTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityArgumentLocalizationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityArgumentLocalizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityArgumentLocalization::class)]
#[CoversClass(CapabilityArgumentLocalizationTransformer::class)]
final class CapabilityArgumentLocalizationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $capabilityArgumentI18nModel = self::createStub(CapabilityArgumentI18nInterface::class);
        $capabilityArgumentI18nTransformer = self::createStub(CapabilityArgumentI18nTransformerInterface::class);
        $capabilityArgumentI18nTransformer->method('transform')->willReturn($capabilityArgumentI18nModel);
        $data = [
            CapabilityArgumentLocalizationTransformerInterface::KEY_I18N => ['test-key' => ['test-nested']],
            CapabilityArgumentLocalizationTransformerInterface::KEY_LABEL => 'test-label',
            CapabilityArgumentLocalizationTransformerInterface::KEY_DESCRIPTION => 'test-description',
        ];

        $transformer = new CapabilityArgumentLocalizationTransformer($capabilityArgumentI18nTransformer);

        $actual = $transformer->transform($data);

        self::assertSame(['test-key' => $capabilityArgumentI18nModel], $actual->getI18n());
        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-description', $actual->getDescription());
    }

    public function testTransformI18n(): void
    {
        $capabilityArgumentI18nModel = self::createStub(CapabilityArgumentI18nInterface::class);
        $capabilityArgumentI18nTransformer = self::createStub(CapabilityArgumentI18nTransformerInterface::class);
        $capabilityArgumentI18nTransformer->method('transform')->willReturn($capabilityArgumentI18nModel);
        $transformer = new CapabilityArgumentLocalizationTransformer($capabilityArgumentI18nTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getI18n());
        self::assertNull($transformer->transform($base + [CapabilityArgumentLocalizationTransformerInterface::KEY_I18N => 'test-not-array'])->getI18n());
        self::assertSame(['test-key' => $capabilityArgumentI18nModel], $transformer->transform($base + [CapabilityArgumentLocalizationTransformerInterface::KEY_I18N => ['test-key' => ['test-nested'], 'test-skipped' => 'test-not-array']])->getI18n());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new CapabilityArgumentLocalizationTransformer(self::createStub(CapabilityArgumentI18nTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[CapabilityArgumentLocalizationTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'labelValid' => [[CapabilityArgumentLocalizationTransformerInterface::KEY_LABEL => 'test-label'], 'getLabel', 'test-label'];
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[CapabilityArgumentLocalizationTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[CapabilityArgumentLocalizationTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $capabilityArgumentI18nModel = self::createStub(CapabilityArgumentI18nInterface::class);
        $capabilityArgumentI18nTransformer = self::createStub(CapabilityArgumentI18nTransformerInterface::class);
        $capabilityArgumentI18nTransformer->method('transform')->willReturn($capabilityArgumentI18nModel);
        $transformer = new CapabilityArgumentLocalizationTransformer($capabilityArgumentI18nTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getI18n());
        self::assertNull($actual->getLabel());
        self::assertNull($actual->getDescription());
    }
}
