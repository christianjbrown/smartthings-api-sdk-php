<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\TemperatureConversionsItemForDevicePresentation;
use ChristianBrown\SmartThings\Transformer\TemperatureConversionsItemForDevicePresentationTransformer;
use ChristianBrown\SmartThings\Transformer\TemperatureConversionsItemForDevicePresentationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(TemperatureConversionsItemForDevicePresentation::class)]
#[CoversClass(TemperatureConversionsItemForDevicePresentationTransformer::class)]
final class TemperatureConversionsItemForDevicePresentationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_CAPABILITY => 'test-capability',
            TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_VERSION => 7,
            TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_VALUE => 'test-value',
            TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_UNIT => 'test-unit',
        ];

        $transformer = new TemperatureConversionsItemForDevicePresentationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-value', $actual->getValue());
        self::assertSame('test-unit', $actual->getUnit());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new TemperatureConversionsItemForDevicePresentationTransformer();

        $actual = $transformer->transform([TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_CAPABILITY => 'test-capability', TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_VALUE => 'test-value'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new TemperatureConversionsItemForDevicePresentationTransformer();

        $actual = $transformer->transform([TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_CAPABILITY => 'test-capability', TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_VALUE => 'test-value']);

        self::assertNull($actual->getVersion());
        self::assertNull($actual->getUnit());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new TemperatureConversionsItemForDevicePresentationTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'capabilityAbsent' => [[TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_VALUE => 'test-value'], sprintf(TemperatureConversionsItemForDevicePresentationTransformerInterface::UNEXPECTED_STRING_SPRINTF, TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_CAPABILITY)];
        yield 'capabilityWrongType' => [[TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_VALUE => 'test-value', TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_CAPABILITY => 42], sprintf(TemperatureConversionsItemForDevicePresentationTransformerInterface::UNEXPECTED_STRING_SPRINTF, TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_CAPABILITY)];
        yield 'valueAbsent' => [[TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_CAPABILITY => 'test-capability'], sprintf(TemperatureConversionsItemForDevicePresentationTransformerInterface::UNEXPECTED_STRING_SPRINTF, TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_CAPABILITY => 'test-capability', TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_VALUE => 42], sprintf(TemperatureConversionsItemForDevicePresentationTransformerInterface::UNEXPECTED_STRING_SPRINTF, TemperatureConversionsItemForDevicePresentationTransformerInterface::KEY_VALUE)];
    }
}
