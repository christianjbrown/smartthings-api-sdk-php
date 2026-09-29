<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityArgumentLocalizationInterface;
use ChristianBrown\SmartThings\Model\CapabilityCommandLocalization;
use ChristianBrown\SmartThings\Transformer\CapabilityArgumentLocalizationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityCommandLocalizationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityCommandLocalizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityCommandLocalization::class)]
#[CoversClass(CapabilityCommandLocalizationTransformer::class)]
final class CapabilityCommandLocalizationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $capabilityArgumentLocalizationModel = self::createStub(CapabilityArgumentLocalizationInterface::class);
        $capabilityArgumentLocalizationTransformer = self::createStub(CapabilityArgumentLocalizationTransformerInterface::class);
        $capabilityArgumentLocalizationTransformer->method('transform')->willReturn($capabilityArgumentLocalizationModel);
        $data = [
            CapabilityCommandLocalizationTransformerInterface::KEY_LABEL => 'test-label',
            CapabilityCommandLocalizationTransformerInterface::KEY_DESCRIPTION => 'test-description',
            CapabilityCommandLocalizationTransformerInterface::KEY_ARGUMENTS => ['test-key' => ['test-nested']],
        ];

        $transformer = new CapabilityCommandLocalizationTransformer($capabilityArgumentLocalizationTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-description', $actual->getDescription());
        self::assertSame(['test-key' => $capabilityArgumentLocalizationModel], $actual->getArguments());
    }

    public function testTransformArguments(): void
    {
        $capabilityArgumentLocalizationModel = self::createStub(CapabilityArgumentLocalizationInterface::class);
        $capabilityArgumentLocalizationTransformer = self::createStub(CapabilityArgumentLocalizationTransformerInterface::class);
        $capabilityArgumentLocalizationTransformer->method('transform')->willReturn($capabilityArgumentLocalizationModel);
        $transformer = new CapabilityCommandLocalizationTransformer($capabilityArgumentLocalizationTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getArguments());
        self::assertNull($transformer->transform($base + [CapabilityCommandLocalizationTransformerInterface::KEY_ARGUMENTS => 'test-not-array'])->getArguments());
        self::assertSame(['test-key' => $capabilityArgumentLocalizationModel], $transformer->transform($base + [CapabilityCommandLocalizationTransformerInterface::KEY_ARGUMENTS => ['test-key' => ['test-nested'], 'test-skipped' => 'test-not-array']])->getArguments());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new CapabilityCommandLocalizationTransformer(self::createStub(CapabilityArgumentLocalizationTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'labelAbsent' => [[], 'getLabel', null];
        yield 'labelWrongType' => [[CapabilityCommandLocalizationTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'labelValid' => [[CapabilityCommandLocalizationTransformerInterface::KEY_LABEL => 'test-label'], 'getLabel', 'test-label'];
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[CapabilityCommandLocalizationTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[CapabilityCommandLocalizationTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $capabilityArgumentLocalizationModel = self::createStub(CapabilityArgumentLocalizationInterface::class);
        $capabilityArgumentLocalizationTransformer = self::createStub(CapabilityArgumentLocalizationTransformerInterface::class);
        $capabilityArgumentLocalizationTransformer->method('transform')->willReturn($capabilityArgumentLocalizationModel);
        $transformer = new CapabilityCommandLocalizationTransformer($capabilityArgumentLocalizationTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getLabel());
        self::assertNull($actual->getDescription());
        self::assertNull($actual->getArguments());
    }
}
