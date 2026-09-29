<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ServiceCapabilityDataAlertItemLastUpdateTime;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataAlertItemLastUpdateTimeTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceCapabilityDataAlertItemLastUpdateTime::class)]
#[CoversClass(ServiceCapabilityDataAlertItemLastUpdateTimeTransformer::class)]
final class ServiceCapabilityDataAlertItemLastUpdateTimeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface::KEY_VALUE => 'test-value',
        ];

        $transformer = new ServiceCapabilityDataAlertItemLastUpdateTimeTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-value', $actual->getValue());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ServiceCapabilityDataAlertItemLastUpdateTimeTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'valueAbsent' => [[], 'getValue', null];
        yield 'valueWrongType' => [[ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface::KEY_VALUE => 42], 'getValue', null];
        yield 'valueValid' => [[ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface::KEY_VALUE => 'test-value'], 'getValue', 'test-value'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new ServiceCapabilityDataAlertItemLastUpdateTimeTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getValue());
    }
}
