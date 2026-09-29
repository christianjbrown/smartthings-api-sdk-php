<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityAttributeLabelInterface;
use ChristianBrown\SmartThings\Model\CapabilityAttributeLocalization;
use ChristianBrown\SmartThings\Transformer\CapabilityAttributeLabelTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityAttributeLocalizationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityAttributeLocalizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityAttributeLocalization::class)]
#[CoversClass(CapabilityAttributeLocalizationTransformer::class)]
final class CapabilityAttributeLocalizationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $capabilityAttributeLabelModel = self::createStub(CapabilityAttributeLabelInterface::class);
        $capabilityAttributeLabelTransformer = self::createStub(CapabilityAttributeLabelTransformerInterface::class);
        $capabilityAttributeLabelTransformer->method('transform')->willReturn($capabilityAttributeLabelModel);
        $data = [
            CapabilityAttributeLocalizationTransformerInterface::KEY_LABEL => 'test-label',
            CapabilityAttributeLocalizationTransformerInterface::KEY_DESCRIPTION => 'test-description',
            CapabilityAttributeLocalizationTransformerInterface::KEY_DISPLAY_TEMPLATE => 'test-display-template',
            CapabilityAttributeLocalizationTransformerInterface::KEY_I18N => ['test-key' => ['test-inner-key' => ['test-nested']]],
        ];

        $transformer = new CapabilityAttributeLocalizationTransformer($capabilityAttributeLabelTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-description', $actual->getDescription());
        self::assertSame('test-display-template', $actual->getDisplayTemplate());
        self::assertSame(['test-key' => ['test-inner-key' => $capabilityAttributeLabelModel]], $actual->getI18n());
    }

    public function testTransformI18n(): void
    {
        $capabilityAttributeLabelModel = self::createStub(CapabilityAttributeLabelInterface::class);
        $capabilityAttributeLabelTransformer = self::createStub(CapabilityAttributeLabelTransformerInterface::class);
        $capabilityAttributeLabelTransformer->method('transform')->willReturn($capabilityAttributeLabelModel);
        $transformer = new CapabilityAttributeLocalizationTransformer($capabilityAttributeLabelTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getI18n());
        self::assertNull($transformer->transform($base + [CapabilityAttributeLocalizationTransformerInterface::KEY_I18N => 'test-not-array'])->getI18n());
        self::assertSame(['test-key' => ['test-inner-key' => $capabilityAttributeLabelModel]], $transformer->transform($base + [CapabilityAttributeLocalizationTransformerInterface::KEY_I18N => ['test-key' => ['test-inner-key' => ['test-nested'], 'test-inner-skipped' => 'test-not-array'], 'test-skipped' => 'test-not-array']])->getI18n());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new CapabilityAttributeLocalizationTransformer(self::createStub(CapabilityAttributeLabelTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[CapabilityAttributeLocalizationTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'labelValid' => [[CapabilityAttributeLocalizationTransformerInterface::KEY_LABEL => 'test-label'], 'getLabel', 'test-label'];
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[CapabilityAttributeLocalizationTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[CapabilityAttributeLocalizationTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
        yield 'displayTemplateAbsent' => [[], 'getDisplayTemplate', null];
        yield 'displayTemplateWrongType' => [[CapabilityAttributeLocalizationTransformerInterface::KEY_DISPLAY_TEMPLATE => 42], 'getDisplayTemplate', null];
        yield 'displayTemplateValid' => [[CapabilityAttributeLocalizationTransformerInterface::KEY_DISPLAY_TEMPLATE => 'test-display-template'], 'getDisplayTemplate', 'test-display-template'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $capabilityAttributeLabelModel = self::createStub(CapabilityAttributeLabelInterface::class);
        $capabilityAttributeLabelTransformer = self::createStub(CapabilityAttributeLabelTransformerInterface::class);
        $capabilityAttributeLabelTransformer->method('transform')->willReturn($capabilityAttributeLabelModel);
        $transformer = new CapabilityAttributeLocalizationTransformer($capabilityAttributeLabelTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getLabel());
        self::assertNull($actual->getDescription());
        self::assertNull($actual->getDisplayTemplate());
        self::assertNull($actual->getI18n());
    }
}
