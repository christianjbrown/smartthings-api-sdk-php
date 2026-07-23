<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\HubInstalledDriver;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriverTransformer;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriverTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(HubInstalledDriver::class)]
#[CoversClass(HubInstalledDriverTransformer::class)]
final class HubInstalledDriverTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            HubInstalledDriverTransformerInterface::KEY_DRIVER_ID => 'test-driver-id',
            HubInstalledDriverTransformerInterface::KEY_CHANNEL_ID => 'test-channel-id',
            HubInstalledDriverTransformerInterface::KEY_DESCRIPTION => 'Test description',
            HubInstalledDriverTransformerInterface::KEY_DEVELOPER => 'Test Developer',
            HubInstalledDriverTransformerInterface::KEY_NAME => 'Test Driver',
            HubInstalledDriverTransformerInterface::KEY_VENDOR_SUPPORT_INFORMATION => 'support@example.com',
            HubInstalledDriverTransformerInterface::KEY_VERSION => '2024-01-01',
        ];

        $transformer = new HubInstalledDriverTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-driver-id', $actual->getDriverId());
        self::assertSame('test-channel-id', $actual->getChannelId());
        self::assertSame('Test description', $actual->getDescription());
        self::assertSame('Test Developer', $actual->getDeveloper());
        self::assertSame('Test Driver', $actual->getName());
        self::assertSame('support@example.com', $actual->getVendorSupportInformation());
        self::assertSame('2024-01-01', $actual->getVersion());
    }

    /**
     * Exercises every optional field's absent / wrong-type / valid branches.
     *
     * @param array<string, mixed>   $data
     * @param array<string, ?string> $expected
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $data, array $expected): void
    {
        $transformer = new HubInstalledDriverTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-driver-id', $actual->getDriverId());
        self::assertSame($expected['channelId'], $actual->getChannelId());
        self::assertSame($expected['description'], $actual->getDescription());
        self::assertSame($expected['developer'], $actual->getDeveloper());
        self::assertSame($expected['name'], $actual->getName());
        self::assertSame($expected['vendorSupportInformation'], $actual->getVendorSupportInformation());
        self::assertSame($expected['version'], $actual->getVersion());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, array<string, ?string>}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        $id = HubInstalledDriverTransformerInterface::KEY_DRIVER_ID;
        $channelId = HubInstalledDriverTransformerInterface::KEY_CHANNEL_ID;
        $description = HubInstalledDriverTransformerInterface::KEY_DESCRIPTION;
        $developer = HubInstalledDriverTransformerInterface::KEY_DEVELOPER;
        $name = HubInstalledDriverTransformerInterface::KEY_NAME;
        $vendor = HubInstalledDriverTransformerInterface::KEY_VENDOR_SUPPORT_INFORMATION;
        $version = HubInstalledDriverTransformerInterface::KEY_VERSION;

        $none = ['channelId' => null, 'description' => null, 'developer' => null, 'name' => null, 'vendorSupportInformation' => null, 'version' => null];

        yield 'allAbsent' => [[$id => 'test-driver-id'], $none];
        yield 'allValid' => [
            [$id => 'test-driver-id', $channelId => 'test-channel-id', $description => 'Test description', $developer => 'Test Developer', $name => 'Test Driver', $vendor => 'support@example.com', $version => '2024-01-01'],
            ['channelId' => 'test-channel-id', 'description' => 'Test description', 'developer' => 'Test Developer', 'name' => 'Test Driver', 'vendorSupportInformation' => 'support@example.com', 'version' => '2024-01-01'],
        ];
        yield 'channelIdWrongType' => [[$id => 'test-driver-id', $channelId => 42], $none];
        yield 'descriptionWrongType' => [[$id => 'test-driver-id', $description => 42], $none];
        yield 'developerWrongType' => [[$id => 'test-driver-id', $developer => 42], $none];
        yield 'nameWrongType' => [[$id => 'test-driver-id', $name => 42], $none];
        yield 'vendorSupportInformationWrongType' => [[$id => 'test-driver-id', $vendor => 42], $none];
        yield 'versionWrongType' => [[$id => 'test-driver-id', $version => 42], $none];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[HubInstalledDriverTransformerInterface::KEY_DRIVER_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new HubInstalledDriverTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(HubInstalledDriverTransformerInterface::UNEXPECTED_STRING_SPRINTF, HubInstalledDriverTransformerInterface::KEY_DRIVER_ID));
        $transformer->transform($data);
    }
}
