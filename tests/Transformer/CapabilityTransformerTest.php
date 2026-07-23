<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Capability;
use ChristianBrown\SmartThings\Transformer\CapabilityTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(Capability::class)]
#[CoversClass(CapabilityTransformer::class)]
final class CapabilityTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CapabilityTransformerInterface::KEY_ID => 'test-capability-id',
            CapabilityTransformerInterface::KEY_NAME => 'test-name',
            CapabilityTransformerInterface::KEY_STATUS => 'live',
            CapabilityTransformerInterface::KEY_VERSION => 1,
        ];

        $transformer = new CapabilityTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-capability-id', $actual->getId());
        self::assertSame('test-name', $actual->getName());
        self::assertSame('live', $actual->getStatus());
        self::assertSame(1, $actual->getVersion());
    }

    /**
     * Exercises the optional name, status, and version fields in each of their
     * three states: absent, present-but-wrong-type, or present-and-valid.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldCombinationsCases')]
    public function testTransformOptionalFieldCombinations(array $data, ?string $expectedName, ?string $expectedStatus, ?int $expectedVersion): void
    {
        $transformer = new CapabilityTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-capability-id', $actual->getId());
        self::assertSame($expectedName, $actual->getName());
        self::assertSame($expectedStatus, $actual->getStatus());
        self::assertSame($expectedVersion, $actual->getVersion());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?int}>
     */
    public static function provideTransformOptionalFieldCombinationsCases(): iterable
    {
        $nameStates = [
            'nameAbsent' => [null, null],
            'nameWrongType' => [42, null],
            'nameValid' => ['test-name', 'test-name'],
        ];
        $statusStates = [
            'statusAbsent' => [null, null],
            'statusWrongType' => [42, null],
            'statusValid' => ['live', 'live'],
        ];
        $versionStates = [
            'versionAbsent' => [null, null],
            'versionWrongType' => ['not-an-int', null],
            'versionValid' => [1, 1],
        ];

        foreach ($nameStates as $nameName => [$nameValue, $expectedName]) {
            foreach ($statusStates as $statusName => [$statusValue, $expectedStatus]) {
                foreach ($versionStates as $versionName => [$versionValue, $expectedVersion]) {
                    $data = [CapabilityTransformerInterface::KEY_ID => 'test-capability-id'];
                    if (null !== $nameValue) {
                        $data[CapabilityTransformerInterface::KEY_NAME] = $nameValue;
                    }
                    if (null !== $statusValue) {
                        $data[CapabilityTransformerInterface::KEY_STATUS] = $statusValue;
                    }
                    if (null !== $versionValue) {
                        $data[CapabilityTransformerInterface::KEY_VERSION] = $versionValue;
                    }

                    yield sprintf('%s, %s, %s', $nameName, $statusName, $versionName) => [$data, $expectedName, $expectedStatus, $expectedVersion];
                }
            }
        }
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[CapabilityTransformerInterface::KEY_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new CapabilityTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CapabilityTransformerInterface::UNEXPECTED_STRING_SPRINTF, CapabilityTransformerInterface::KEY_ID));
        $transformer->transform($data);
    }
}
