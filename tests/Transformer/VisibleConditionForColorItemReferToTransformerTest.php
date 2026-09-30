<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemReferTo;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForColorItemReferToTransformer;
use ChristianBrown\SmartThings\Transformer\VisibleConditionForColorItemReferToTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(VisibleConditionForColorItemReferTo::class)]
#[CoversClass(VisibleConditionForColorItemReferToTransformer::class)]
final class VisibleConditionForColorItemReferToTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            VisibleConditionForColorItemReferToTransformerInterface::KEY_COMPONENT => 'test-component',
            VisibleConditionForColorItemReferToTransformerInterface::KEY_CAPABILITY => 'test-capability',
            VisibleConditionForColorItemReferToTransformerInterface::KEY_VERSION => 7,
            VisibleConditionForColorItemReferToTransformerInterface::KEY_VALUE => 'test-value',
            VisibleConditionForColorItemReferToTransformerInterface::KEY_VALUE_TYPE => 'test-value-type',
        ];

        $transformer = new VisibleConditionForColorItemReferToTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-value-type', $actual->getValueType());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new VisibleConditionForColorItemReferToTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'componentAbsent' => [[VisibleConditionForColorItemReferToTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionForColorItemReferToTransformerInterface::KEY_VALUE => 'test-value'], 'getComponent', null];
        yield 'componentWrongType' => [[VisibleConditionForColorItemReferToTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionForColorItemReferToTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForColorItemReferToTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'capabilityAbsent' => [[VisibleConditionForColorItemReferToTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForColorItemReferToTransformerInterface::KEY_VALUE => 'test-value'], 'getCapability', null];
        yield 'capabilityWrongType' => [[VisibleConditionForColorItemReferToTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForColorItemReferToTransformerInterface::KEY_VALUE => 'test-value', VisibleConditionForColorItemReferToTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
        yield 'valueAbsent' => [[VisibleConditionForColorItemReferToTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForColorItemReferToTransformerInterface::KEY_CAPABILITY => 'test-capability'], 'getValue', null];
        yield 'valueWrongType' => [[VisibleConditionForColorItemReferToTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForColorItemReferToTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionForColorItemReferToTransformerInterface::KEY_VALUE => 42], 'getValue', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new VisibleConditionForColorItemReferToTransformer();

        $actual = $transformer->transform([VisibleConditionForColorItemReferToTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForColorItemReferToTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionForColorItemReferToTransformerInterface::KEY_VALUE => 'test-value'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[VisibleConditionForColorItemReferToTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[VisibleConditionForColorItemReferToTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'valueTypeAbsent' => [[], 'getValueType', null];
        yield 'valueTypeWrongType' => [[VisibleConditionForColorItemReferToTransformerInterface::KEY_VALUE_TYPE => 42], 'getValueType', null];
        yield 'valueTypeValid' => [[VisibleConditionForColorItemReferToTransformerInterface::KEY_VALUE_TYPE => 'test-value-type'], 'getValueType', 'test-value-type'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new VisibleConditionForColorItemReferToTransformer();

        $actual = $transformer->transform([VisibleConditionForColorItemReferToTransformerInterface::KEY_COMPONENT => 'test-component', VisibleConditionForColorItemReferToTransformerInterface::KEY_CAPABILITY => 'test-capability', VisibleConditionForColorItemReferToTransformerInterface::KEY_VALUE => 'test-value']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getValueType());
    }
}
