<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusCameraImage;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraImageTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraImageTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusCameraImage::class)]
#[CoversClass(BasicPlusCameraImageTransformer::class)]
final class BasicPlusCameraImageTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            BasicPlusCameraImageTransformerInterface::KEY_CAPABILITY => 'test-capability',
            BasicPlusCameraImageTransformerInterface::KEY_VERSION => 7,
            BasicPlusCameraImageTransformerInterface::KEY_COMPONENT => 'test-component',
            BasicPlusCameraImageTransformerInterface::KEY_VALUE => 'test-value',
        ];

        $transformer = new BasicPlusCameraImageTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-capability', $actual->getCapability());
        self::assertSame(7, $actual->getVersion());
        self::assertSame('test-component', $actual->getComponent());
        self::assertSame('test-value', $actual->getValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusCameraImageTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'capabilityAbsent' => [[BasicPlusCameraImageTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusCameraImageTransformerInterface::KEY_VALUE => 'test-value'], 'getCapability', null];
        yield 'capabilityWrongType' => [[BasicPlusCameraImageTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusCameraImageTransformerInterface::KEY_VALUE => 'test-value', BasicPlusCameraImageTransformerInterface::KEY_CAPABILITY => 42], 'getCapability', null];
        yield 'componentAbsent' => [[BasicPlusCameraImageTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusCameraImageTransformerInterface::KEY_VALUE => 'test-value'], 'getComponent', null];
        yield 'componentWrongType' => [[BasicPlusCameraImageTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusCameraImageTransformerInterface::KEY_VALUE => 'test-value', BasicPlusCameraImageTransformerInterface::KEY_COMPONENT => 42], 'getComponent', null];
        yield 'valueAbsent' => [[BasicPlusCameraImageTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusCameraImageTransformerInterface::KEY_COMPONENT => 'test-component'], 'getValue', null];
        yield 'valueWrongType' => [[BasicPlusCameraImageTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusCameraImageTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusCameraImageTransformerInterface::KEY_VALUE => 42], 'getValue', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusCameraImageTransformer();

        $actual = $transformer->transform([BasicPlusCameraImageTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusCameraImageTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusCameraImageTransformerInterface::KEY_VALUE => 'test-value'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'versionAbsent' => [[], 'getVersion', null];
        yield 'versionWrongType' => [[BasicPlusCameraImageTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
        yield 'versionValid' => [[BasicPlusCameraImageTransformerInterface::KEY_VERSION => 7], 'getVersion', 7];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new BasicPlusCameraImageTransformer();

        $actual = $transformer->transform([BasicPlusCameraImageTransformerInterface::KEY_CAPABILITY => 'test-capability', BasicPlusCameraImageTransformerInterface::KEY_COMPONENT => 'test-component', BasicPlusCameraImageTransformerInterface::KEY_VALUE => 'test-value']);

        self::assertNull($actual->getVersion());
    }
}
