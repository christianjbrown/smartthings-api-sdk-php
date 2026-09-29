<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\MatterVersion;
use ChristianBrown\SmartThings\Transformer\MatterVersionTransformer;
use ChristianBrown\SmartThings\Transformer\MatterVersionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(MatterVersion::class)]
#[CoversClass(MatterVersionTransformer::class)]
final class MatterVersionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            MatterVersionTransformerInterface::KEY_HARDWARE => 7,
            MatterVersionTransformerInterface::KEY_HARDWARE_LABEL => 'test-hardware-label',
            MatterVersionTransformerInterface::KEY_SOFTWARE => 1.5,
            MatterVersionTransformerInterface::KEY_SOFTWARE_LABEL => 'test-software-label',
        ];

        $transformer = new MatterVersionTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(7, $actual->getHardware());
        self::assertSame('test-hardware-label', $actual->getHardwareLabel());
        self::assertSame(1.5, $actual->getSoftware());
        self::assertSame('test-software-label', $actual->getSoftwareLabel());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new MatterVersionTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'hardwareAbsent' => [[], 'getHardware', null];
        yield 'hardwareWrongType' => [[MatterVersionTransformerInterface::KEY_HARDWARE => 'not-int'], 'getHardware', null];
        yield 'hardwareValid' => [[MatterVersionTransformerInterface::KEY_HARDWARE => 7], 'getHardware', 7];
        yield 'hardwareLabelAbsent' => [[], 'getHardwareLabel', null];
        yield 'hardwareLabelWrongType' => [[MatterVersionTransformerInterface::KEY_HARDWARE_LABEL => 42], 'getHardwareLabel', null];
        yield 'hardwareLabelValid' => [[MatterVersionTransformerInterface::KEY_HARDWARE_LABEL => 'test-hardware-label'], 'getHardwareLabel', 'test-hardware-label'];
        yield 'softwareAbsent' => [[], 'getSoftware', null];
        yield 'softwareWrongType' => [[MatterVersionTransformerInterface::KEY_SOFTWARE => 'not-number'], 'getSoftware', null];
        yield 'softwareValid' => [[MatterVersionTransformerInterface::KEY_SOFTWARE => 1.5], 'getSoftware', 1.5];
        yield 'softwareLabelAbsent' => [[], 'getSoftwareLabel', null];
        yield 'softwareLabelWrongType' => [[MatterVersionTransformerInterface::KEY_SOFTWARE_LABEL => 42], 'getSoftwareLabel', null];
        yield 'softwareLabelValid' => [[MatterVersionTransformerInterface::KEY_SOFTWARE_LABEL => 'test-software-label'], 'getSoftwareLabel', 'test-software-label'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new MatterVersionTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getHardware());
        self::assertNull($actual->getHardwareLabel());
        self::assertNull($actual->getSoftware());
        self::assertNull($actual->getSoftwareLabel());
    }
}
