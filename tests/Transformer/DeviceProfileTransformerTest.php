<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceProfile;
use ChristianBrown\SmartThings\Transformer\DeviceProfileTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceProfileTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceProfile::class)]
#[CoversClass(DeviceProfileTransformer::class)]
final class DeviceProfileTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceProfileTransformerInterface::KEY_ID => 'test-profile-id',
            DeviceProfileTransformerInterface::KEY_NAME => 'test-name',
            DeviceProfileTransformerInterface::KEY_STATUS => 'PUBLISHED',
        ];

        $transformer = new DeviceProfileTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-profile-id', $actual->getId());
        self::assertSame('test-name', $actual->getName());
        self::assertSame('PUBLISHED', $actual->getStatus());
    }

    /**
     * Exercises the optional name and status fields in each of their three
     * states: absent, present-but-wrong-type, or present-and-valid.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldCombinationsCases')]
    public function testTransformOptionalFieldCombinations(array $data, ?string $expectedName, ?string $expectedStatus): void
    {
        $transformer = new DeviceProfileTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-profile-id', $actual->getId());
        self::assertSame($expectedName, $actual->getName());
        self::assertSame($expectedStatus, $actual->getStatus());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
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
            'statusValid' => ['PUBLISHED', 'PUBLISHED'],
        ];

        foreach ($nameStates as $nameName => [$nameValue, $expectedName]) {
            foreach ($statusStates as $statusName => [$statusValue, $expectedStatus]) {
                $data = [DeviceProfileTransformerInterface::KEY_ID => 'test-profile-id'];
                if (null !== $nameValue) {
                    $data[DeviceProfileTransformerInterface::KEY_NAME] = $nameValue;
                }
                if (null !== $statusValue) {
                    $data[DeviceProfileTransformerInterface::KEY_STATUS] = $statusValue;
                }

                yield sprintf('%s, %s', $nameName, $statusName) => [$data, $expectedName, $expectedStatus];
            }
        }
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[DeviceProfileTransformerInterface::KEY_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new DeviceProfileTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceProfileTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceProfileTransformerInterface::KEY_ID));
        $transformer->transform($data);
    }
}
