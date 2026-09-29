<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AttributeState;
use ChristianBrown\SmartThings\Transformer\AttributeStateTransformer;
use ChristianBrown\SmartThings\Transformer\AttributeStateTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AttributeState::class)]
#[CoversClass(AttributeStateTransformer::class)]
final class AttributeStateTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AttributeStateTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value'],
            AttributeStateTransformerInterface::KEY_UNIT => 'test-unit',
            AttributeStateTransformerInterface::KEY_DATA => ['test-data-key' => 'test-value'],
            AttributeStateTransformerInterface::KEY_TIMESTAMP => 'test-timestamp',
        ];

        $transformer = new AttributeStateTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(['test-value-key' => 'test-value'], $actual->getValue());
        self::assertSame('test-unit', $actual->getUnit());
        self::assertSame(['test-data-key' => 'test-value'], $actual->getData());
        self::assertSame('test-timestamp', $actual->getTimestamp());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new AttributeStateTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[AttributeStateTransformerInterface::KEY_VALUE => 'not-array'], 'getValue', null];
        yield 'valueValid' => [[AttributeStateTransformerInterface::KEY_VALUE => ['test-value-key' => 'test-value']], 'getValue', ['test-value-key' => 'test-value']];
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[AttributeStateTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[AttributeStateTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
        yield 'dataAbsent' => [[], 'getData', null];
        yield 'dataWrongType' => [[AttributeStateTransformerInterface::KEY_DATA => 'not-array'], 'getData', null];
        yield 'dataValid' => [[AttributeStateTransformerInterface::KEY_DATA => ['test-data-key' => 'test-value']], 'getData', ['test-data-key' => 'test-value']];
        yield 'timestampAbsent' => [[], 'getTimestamp', null];
        yield 'timestampWrongType' => [[AttributeStateTransformerInterface::KEY_TIMESTAMP => 42], 'getTimestamp', null];
        yield 'timestampValid' => [[AttributeStateTransformerInterface::KEY_TIMESTAMP => 'test-timestamp'], 'getTimestamp', 'test-timestamp'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new AttributeStateTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getValue());
        self::assertNull($actual->getUnit());
        self::assertNull($actual->getData());
        self::assertNull($actual->getTimestamp());
    }
}
