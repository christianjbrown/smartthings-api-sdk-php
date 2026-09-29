<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceRelationship;
use ChristianBrown\SmartThings\Transformer\DeviceRelationshipTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceRelationshipTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceRelationship::class)]
#[CoversClass(DeviceRelationshipTransformer::class)]
final class DeviceRelationshipTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceRelationshipTransformerInterface::KEY_DEVICE_ID => 'test-device-id',
            DeviceRelationshipTransformerInterface::KEY_RELATIONSHIP_TYPE => 'test-relationship-type',
            DeviceRelationshipTransformerInterface::KEY_ON_DELETE => 'test-on-delete',
            DeviceRelationshipTransformerInterface::KEY_ON_LOCATION_MOVE => 'test-on-location-move',
            DeviceRelationshipTransformerInterface::KEY_ON_OWNERSHIP_TRANSFER => 'test-on-ownership-transfer',
        ];

        $transformer = new DeviceRelationshipTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-device-id', $actual->getDeviceId());
        self::assertSame('test-relationship-type', $actual->getRelationshipType());
        self::assertSame('test-on-delete', $actual->getOnDelete());
        self::assertSame('test-on-location-move', $actual->getOnLocationMove());
        self::assertSame('test-on-ownership-transfer', $actual->getOnOwnershipTransfer());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceRelationshipTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'deviceIdAbsent' => [[], 'getDeviceId', null];
        yield 'deviceIdWrongType' => [[DeviceRelationshipTransformerInterface::KEY_DEVICE_ID => 42], 'getDeviceId', null];
        yield 'deviceIdValid' => [[DeviceRelationshipTransformerInterface::KEY_DEVICE_ID => 'test-device-id'], 'getDeviceId', 'test-device-id'];
        yield 'relationshipTypeAbsent' => [[], 'getRelationshipType', null];
        yield 'relationshipTypeWrongType' => [[DeviceRelationshipTransformerInterface::KEY_RELATIONSHIP_TYPE => 42], 'getRelationshipType', null];
        yield 'relationshipTypeValid' => [[DeviceRelationshipTransformerInterface::KEY_RELATIONSHIP_TYPE => 'test-relationship-type'], 'getRelationshipType', 'test-relationship-type'];
        yield 'onDeleteAbsent' => [[], 'getOnDelete', null];
        yield 'onDeleteWrongType' => [[DeviceRelationshipTransformerInterface::KEY_ON_DELETE => 42], 'getOnDelete', null];
        yield 'onDeleteValid' => [[DeviceRelationshipTransformerInterface::KEY_ON_DELETE => 'test-on-delete'], 'getOnDelete', 'test-on-delete'];
        yield 'onLocationMoveAbsent' => [[], 'getOnLocationMove', null];
        yield 'onLocationMoveWrongType' => [[DeviceRelationshipTransformerInterface::KEY_ON_LOCATION_MOVE => 42], 'getOnLocationMove', null];
        yield 'onLocationMoveValid' => [[DeviceRelationshipTransformerInterface::KEY_ON_LOCATION_MOVE => 'test-on-location-move'], 'getOnLocationMove', 'test-on-location-move'];
        yield 'onOwnershipTransferAbsent' => [[], 'getOnOwnershipTransfer', null];
        yield 'onOwnershipTransferWrongType' => [[DeviceRelationshipTransformerInterface::KEY_ON_OWNERSHIP_TRANSFER => 42], 'getOnOwnershipTransfer', null];
        yield 'onOwnershipTransferValid' => [[DeviceRelationshipTransformerInterface::KEY_ON_OWNERSHIP_TRANSFER => 'test-on-ownership-transfer'], 'getOnOwnershipTransfer', 'test-on-ownership-transfer'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new DeviceRelationshipTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getDeviceId());
        self::assertNull($actual->getRelationshipType());
        self::assertNull($actual->getOnDelete());
        self::assertNull($actual->getOnLocationMove());
        self::assertNull($actual->getOnOwnershipTransfer());
    }
}
