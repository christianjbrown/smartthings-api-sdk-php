<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DevicePreference;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceTransformer;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DevicePreference::class)]
#[CoversClass(DevicePreferenceTransformer::class)]
final class DevicePreferenceTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DevicePreferenceTransformerInterface::KEY_NAME => 'motionSensitivity',
            DevicePreferenceTransformerInterface::KEY_PREFERENCE_TYPE => 'integer',
            DevicePreferenceTransformerInterface::KEY_VALUE => 5,
        ];

        $transformer = new DevicePreferenceTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('motionSensitivity', $actual->getName());
        self::assertSame('integer', $actual->getPreferenceType());
        self::assertSame(5, $actual->getValue());
    }

    /**
     * Exercises the optional preferenceType field (absent / wrong-type / valid)
     * and every branch of the polymorphic value field (absent / string / bool /
     * int / float / wrong-type), covering the falsy-but-legitimate `false`, `0`
     * and `0.0` values that must not be dropped.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformFieldsCases')]
    public function testTransformFields(array $data, ?string $expectedPreferenceType, null|bool|float|int|string $expectedValue): void
    {
        $transformer = new DevicePreferenceTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('motionSensitivity', $actual->getName());
        self::assertSame($expectedPreferenceType, $actual->getPreferenceType());
        self::assertSame($expectedValue, $actual->getValue());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, null|bool|float|int|string}>
     */
    public static function provideTransformFieldsCases(): iterable
    {
        $name = DevicePreferenceTransformerInterface::KEY_NAME;
        $type = DevicePreferenceTransformerInterface::KEY_PREFERENCE_TYPE;
        $value = DevicePreferenceTransformerInterface::KEY_VALUE;

        yield 'allValid' => [[$name => 'motionSensitivity', $type => 'integer', $value => 5], 'integer', 5];
        yield 'preferenceTypeAbsent' => [[$name => 'motionSensitivity', $value => 5], null, 5];
        yield 'preferenceTypeWrongType' => [[$name => 'motionSensitivity', $type => 42, $value => 5], null, 5];
        yield 'valueString' => [[$name => 'motionSensitivity', $type => 'string', $value => 'auto'], 'string', 'auto'];
        yield 'valueTrue' => [[$name => 'motionSensitivity', $type => 'boolean', $value => true], 'boolean', true];
        yield 'valueFalse' => [[$name => 'motionSensitivity', $type => 'boolean', $value => false], 'boolean', false];
        yield 'valueIntZero' => [[$name => 'motionSensitivity', $type => 'integer', $value => 0], 'integer', 0];
        yield 'valueFloat' => [[$name => 'motionSensitivity', $type => 'number', $value => 1.5], 'number', 1.5];
        yield 'valueFloatZero' => [[$name => 'motionSensitivity', $type => 'number', $value => 0.0], 'number', 0.0];
        yield 'valueAbsent' => [[$name => 'motionSensitivity', $type => 'integer'], 'integer', null];
        yield 'valueWrongType' => [[$name => 'motionSensitivity', $type => 'integer', $value => ['nested']], 'integer', null];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[DevicePreferenceTransformerInterface::KEY_NAME => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new DevicePreferenceTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DevicePreferenceTransformerInterface::UNEXPECTED_STRING_SPRINTF, DevicePreferenceTransformerInterface::KEY_NAME));
        $transformer->transform($data);
    }
}
