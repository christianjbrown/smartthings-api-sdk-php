<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceCommandResult;
use ChristianBrown\SmartThings\Transformer\DeviceCommandResultTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceCommandResultTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DeviceCommandResult::class)]
#[CoversClass(DeviceCommandResultTransformer::class)]
final class DeviceCommandResultTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceCommandResultTransformerInterface::KEY_ID => 'test-command-uuid',
            DeviceCommandResultTransformerInterface::KEY_STATUS => 'ACCEPTED',
        ];

        $transformer = new DeviceCommandResultTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-command-uuid', $actual->getId());
        self::assertSame('ACCEPTED', $actual->getStatus());
    }

    /**
     * Exercises the optional id and status fields in each of their three states:
     * absent, present-but-wrong-type, or present-and-valid.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldCombinationsCases')]
    public function testTransformOptionalFieldCombinations(array $data, ?string $expectedId, ?string $expectedStatus): void
    {
        $transformer = new DeviceCommandResultTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expectedId, $actual->getId());
        self::assertSame($expectedStatus, $actual->getStatus());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldCombinationsCases(): iterable
    {
        $idStates = [
            'idAbsent' => [null, null],
            'idWrongType' => [42, null],
            'idValid' => ['test-command-uuid', 'test-command-uuid'],
        ];
        $statusStates = [
            'statusAbsent' => [null, null],
            'statusWrongType' => [42, null],
            'statusValid' => ['ACCEPTED', 'ACCEPTED'],
        ];

        foreach ($idStates as $idName => [$idValue, $expectedId]) {
            foreach ($statusStates as $statusName => [$statusValue, $expectedStatus]) {
                $data = [];
                if (null !== $idValue) {
                    $data[DeviceCommandResultTransformerInterface::KEY_ID] = $idValue;
                }
                if (null !== $statusValue) {
                    $data[DeviceCommandResultTransformerInterface::KEY_STATUS] = $statusValue;
                }

                yield sprintf('%s, %s', $idName, $statusName) => [$data, $expectedId, $expectedStatus];
            }
        }
    }
}
