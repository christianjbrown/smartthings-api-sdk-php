<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CommandMappingsInterface;
use ChristianBrown\SmartThings\Model\VirtualDeviceDetails;
use ChristianBrown\SmartThings\Transformer\CommandMappingsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VirtualDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\VirtualDeviceDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(VirtualDeviceDetails::class)]
#[CoversClass(VirtualDeviceDetailsTransformer::class)]
final class VirtualDeviceDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $commandMappingsModel = self::createStub(CommandMappingsInterface::class);
        $commandMappingsTransformer = self::createStub(CommandMappingsTransformerInterface::class);
        $commandMappingsTransformer->method('transform')->willReturn($commandMappingsModel);
        $data = [
            VirtualDeviceDetailsTransformerInterface::KEY_NAME => 'test-name',
            VirtualDeviceDetailsTransformerInterface::KEY_HUB_ID => 'test-hub-id',
            VirtualDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id',
            VirtualDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => true,
            VirtualDeviceDetailsTransformerInterface::KEY_COMMAND_MAPPINGS => ['test-nested'],
        ];

        $transformer = new VirtualDeviceDetailsTransformer($commandMappingsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertSame('test-hub-id', $actual->getHubId());
        self::assertSame('test-driver-id', $actual->getDriverId());
        self::assertTrue($actual->getExecutingLocally());
        self::assertSame($commandMappingsModel, $actual->getCommandMappings());
    }

    public function testTransformCommandMappings(): void
    {
        $commandMappingsModel = self::createStub(CommandMappingsInterface::class);
        $commandMappingsTransformer = self::createStub(CommandMappingsTransformerInterface::class);
        $commandMappingsTransformer->method('transform')->willReturn($commandMappingsModel);
        $transformer = new VirtualDeviceDetailsTransformer($commandMappingsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getCommandMappings());
        self::assertNull($transformer->transform($base + [VirtualDeviceDetailsTransformerInterface::KEY_COMMAND_MAPPINGS => 'test-not-array'])->getCommandMappings());
        self::assertSame($commandMappingsModel, $transformer->transform($base + [VirtualDeviceDetailsTransformerInterface::KEY_COMMAND_MAPPINGS => ['test-nested']])->getCommandMappings());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new VirtualDeviceDetailsTransformer(self::createStub(CommandMappingsTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'nameAbsent' => [[], 'getName', null];
        yield 'nameWrongType' => [[VirtualDeviceDetailsTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'nameValid' => [[VirtualDeviceDetailsTransformerInterface::KEY_NAME => 'test-name'], 'getName', 'test-name'];
        yield 'hubIdAbsent' => [[], 'getHubId', null];
        yield 'hubIdWrongType' => [[VirtualDeviceDetailsTransformerInterface::KEY_HUB_ID => 42], 'getHubId', null];
        yield 'hubIdValid' => [[VirtualDeviceDetailsTransformerInterface::KEY_HUB_ID => 'test-hub-id'], 'getHubId', 'test-hub-id'];
        yield 'driverIdAbsent' => [[], 'getDriverId', null];
        yield 'driverIdWrongType' => [[VirtualDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 42], 'getDriverId', null];
        yield 'driverIdValid' => [[VirtualDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'], 'getDriverId', 'test-driver-id'];
        yield 'executingLocallyAbsent' => [[], 'getExecutingLocally', null];
        yield 'executingLocallyWrongType' => [[VirtualDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => 'not-bool'], 'getExecutingLocally', null];
        yield 'executingLocallyValid' => [[VirtualDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => true], 'getExecutingLocally', true];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $commandMappingsModel = self::createStub(CommandMappingsInterface::class);
        $commandMappingsTransformer = self::createStub(CommandMappingsTransformerInterface::class);
        $commandMappingsTransformer->method('transform')->willReturn($commandMappingsModel);
        $transformer = new VirtualDeviceDetailsTransformer($commandMappingsTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getName());
        self::assertNull($actual->getHubId());
        self::assertNull($actual->getDriverId());
        self::assertNull($actual->getExecutingLocally());
        self::assertNull($actual->getCommandMappings());
    }
}
