<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\HubApi;
use ChristianBrown\SmartThings\Api\HubApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\HubEnrolledChannelInterface;
use ChristianBrown\SmartThings\Model\HubInstalledDriverInterface;
use ChristianBrown\SmartThings\Model\HubInterface;
use ChristianBrown\SmartThings\Transformer\HubCharacteristicsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubEnrolledChannelsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriversTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriverTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(HubApi::class)]
#[CoversClass(Token::class)]
final class HubApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCharacteristics(): void
    {
        $data = ['zigbeeChannel' => 20];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(HubApiInterface::API_URL_CHARACTERISTICS_SPRINTF, 'test-hub-id'),
                [],
                self::authHeaders()
            )
            ->willReturn($data);

        $characteristics = ['zigbeeChannel' => 20];

        $characteristicsTransformer = self::createMock(HubCharacteristicsTransformerInterface::class);
        $characteristicsTransformer->expects(self::once())->method('transform')->with($data)->willReturn($characteristics);

        $api = self::createApi($requestSender, characteristicsTransformer: $characteristicsTransformer);

        self::assertSame($characteristics, $api->getCharacteristics('test-hub-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCharacteristicsCaches(): void
    {
        $characteristics = ['zigbeeChannel' => 20];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['zigbeeChannel' => 20]);

        $characteristicsTransformer = self::createMock(HubCharacteristicsTransformerInterface::class);
        $characteristicsTransformer->expects(self::once())->method('transform')->willReturn($characteristics);

        $api = self::createApi($requestSender, characteristicsTransformer: $characteristicsTransformer);

        // Second call is served from the cache without hitting the API.
        self::assertSame($characteristics, $api->getCharacteristics('test-hub-id'));
        self::assertSame($characteristics, $api->getCharacteristics('test-hub-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCharacteristicsSkipsCache(): void
    {
        $characteristics = ['zigbeeChannel' => 20];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['zigbeeChannel' => 20]);

        $characteristicsTransformer = self::createMock(HubCharacteristicsTransformerInterface::class);
        $characteristicsTransformer->expects(self::exactly(2))->method('transform')->willReturn($characteristics);

        $api = self::createApi($requestSender, characteristicsTransformer: $characteristicsTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($characteristics, $api->getCharacteristics('test-hub-id'));
        self::assertSame($characteristics, $api->getCharacteristics('test-hub-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetEnrolledChannels(): void
    {
        $data = ['test-item-1', 'test-item-2'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(HubApiInterface::API_URL_CHANNELS_SPRINTF, 'test-hub-id'),
                [HubApiInterface::KEY_CHANNEL_TYPE => HubApiInterface::CHANNEL_TYPE_DRIVERS],
                self::authHeaders()
            )
            ->willReturn($data);

        $channels = [self::createStub(HubEnrolledChannelInterface::class)];

        $channelsTransformer = self::createMock(HubEnrolledChannelsTransformerInterface::class);
        $channelsTransformer->expects(self::once())->method('transform')->with($data)->willReturn($channels);

        $api = self::createApi($requestSender, channelsTransformer: $channelsTransformer);

        self::assertSame($channels, $api->getEnrolledChannels('test-hub-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetEnrolledChannelsCaches(): void
    {
        $channels = [self::createStub(HubEnrolledChannelInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-item-1']);

        $channelsTransformer = self::createMock(HubEnrolledChannelsTransformerInterface::class);
        $channelsTransformer->expects(self::once())->method('transform')->willReturn($channels);

        $api = self::createApi($requestSender, channelsTransformer: $channelsTransformer);

        // Second call is served from the cache without hitting the API.
        self::assertSame($channels, $api->getEnrolledChannels('test-hub-id'));
        self::assertSame($channels, $api->getEnrolledChannels('test-hub-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetEnrolledChannelsSkipsCache(): void
    {
        $channels = [self::createStub(HubEnrolledChannelInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-item-1']);

        $channelsTransformer = self::createMock(HubEnrolledChannelsTransformerInterface::class);
        $channelsTransformer->expects(self::exactly(2))->method('transform')->willReturn($channels);

        $api = self::createApi($requestSender, channelsTransformer: $channelsTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($channels, $api->getEnrolledChannels('test-hub-id'));
        self::assertSame($channels, $api->getEnrolledChannels('test-hub-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstalledDriver(): void
    {
        $data = ['test-driver-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(HubApiInterface::API_URL_DRIVER_SPRINTF, 'test-hub-id', 'test-driver-id'),
                [],
                self::authHeaders()
            )
            ->willReturn($data);

        $driver = self::createStub(HubInstalledDriverInterface::class);

        $driverTransformer = self::createMock(HubInstalledDriverTransformerInterface::class);
        $driverTransformer->expects(self::once())->method('transform')->with($data)->willReturn($driver);

        $api = self::createApi($requestSender, driverTransformer: $driverTransformer);

        self::assertSame($driver, $api->getInstalledDriver('test-hub-id', 'test-driver-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstalledDriverCaches(): void
    {
        $driver = self::createStub(HubInstalledDriverInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-driver-data']);

        $driverTransformer = self::createMock(HubInstalledDriverTransformerInterface::class);
        $driverTransformer->expects(self::once())->method('transform')->willReturn($driver);

        $api = self::createApi($requestSender, driverTransformer: $driverTransformer);

        // Second call for the same hub and driver is served from the cache without hitting the API.
        self::assertSame($driver, $api->getInstalledDriver('test-hub-id', 'test-driver-id'));
        self::assertSame($driver, $api->getInstalledDriver('test-hub-id', 'test-driver-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c', 'x/y z'])]
    #[TestWith(['../../hubdevices', '../../drivers'])]
    public function testGetInstalledDriverEncodesIds(string $hubId, string $driverId): void
    {
        $data = ['test-driver-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(HubApiInterface::API_URL_DRIVER_SPRINTF, rawurlencode($hubId), rawurlencode($driverId)),
                [],
                self::authHeaders()
            )
            ->willReturn($data);

        $driver = self::createStub(HubInstalledDriverInterface::class);

        $driverTransformer = self::createMock(HubInstalledDriverTransformerInterface::class);
        $driverTransformer->expects(self::once())->method('transform')->with($data)->willReturn($driver);

        $api = self::createApi($requestSender, driverTransformer: $driverTransformer);

        self::assertSame($driver, $api->getInstalledDriver($hubId, $driverId));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstalledDrivers(): void
    {
        $data = ['test-item-1', 'test-item-2'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(HubApiInterface::API_URL_DRIVERS_SPRINTF, 'test-hub-id'),
                [],
                self::authHeaders()
            )
            ->willReturn($data);

        $drivers = [self::createStub(HubInstalledDriverInterface::class)];

        $driversTransformer = self::createMock(HubInstalledDriversTransformerInterface::class);
        $driversTransformer->expects(self::once())->method('transform')->with($data)->willReturn($drivers);

        $api = self::createApi($requestSender, driversTransformer: $driversTransformer);

        self::assertSame($drivers, $api->getInstalledDrivers('test-hub-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstalledDriversCaches(): void
    {
        $drivers = [self::createStub(HubInstalledDriverInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-item-1']);

        $driversTransformer = self::createMock(HubInstalledDriversTransformerInterface::class);
        $driversTransformer->expects(self::once())->method('transform')->willReturn($drivers);

        $api = self::createApi($requestSender, driversTransformer: $driversTransformer);

        // Second call with the same filter is served from the cache without hitting the API.
        self::assertSame($drivers, $api->getInstalledDrivers('test-hub-id'));
        self::assertSame($drivers, $api->getInstalledDrivers('test-hub-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstalledDriversFiltersByDevice(): void
    {
        $data = ['test-item-1'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(HubApiInterface::API_URL_DRIVERS_SPRINTF, 'test-hub-id'),
                [HubApiInterface::KEY_DEVICE_ID => 'test-device-id'],
                self::authHeaders()
            )
            ->willReturn($data);

        $drivers = [self::createStub(HubInstalledDriverInterface::class)];

        $driversTransformer = self::createMock(HubInstalledDriversTransformerInterface::class);
        $driversTransformer->expects(self::once())->method('transform')->with($data)->willReturn($drivers);

        $api = self::createApi($requestSender, driversTransformer: $driversTransformer);

        self::assertSame($drivers, $api->getInstalledDrivers('test-hub-id', 'test-device-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstalledDriverSkipsCache(): void
    {
        $driver = self::createStub(HubInstalledDriverInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-driver-data']);

        $driverTransformer = self::createMock(HubInstalledDriverTransformerInterface::class);
        $driverTransformer->expects(self::exactly(2))->method('transform')->willReturn($driver);

        $api = self::createApi($requestSender, driverTransformer: $driverTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($driver, $api->getInstalledDriver('test-hub-id', 'test-driver-id'));
        self::assertSame($driver, $api->getInstalledDriver('test-hub-id', 'test-driver-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstalledDriversSkipsCache(): void
    {
        $drivers = [self::createStub(HubInstalledDriverInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-item-1']);

        $driversTransformer = self::createMock(HubInstalledDriversTransformerInterface::class);
        $driversTransformer->expects(self::exactly(2))->method('transform')->willReturn($drivers);

        $api = self::createApi($requestSender, driversTransformer: $driversTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($drivers, $api->getInstalledDrivers('test-hub-id'));
        self::assertSame($drivers, $api->getInstalledDrivers('test-hub-id', null, true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetInstalledDriverUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = self::createApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(HubApiInterface::UNEXPECTED_RESPONSE);
        $api->getInstalledDriver('test-hub-id', 'test-driver-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-hub-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(HubApiInterface::API_URL_SPRINTF, 'test-hub-id'),
                [],
                self::authHeaders()
            )
            ->willReturn($data);

        $hub = self::createStub(HubInterface::class);

        $hubTransformer = self::createMock(HubTransformerInterface::class);
        $hubTransformer->expects(self::once())->method('transform')->with($data)->willReturn($hub);

        $api = self::createApi($requestSender, hubTransformer: $hubTransformer);

        self::assertSame($hub, $api->getOneById('test-hub-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $hub = self::createStub(HubInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-hub-data']);

        $hubTransformer = self::createMock(HubTransformerInterface::class);
        $hubTransformer->expects(self::once())->method('transform')->willReturn($hub);

        $api = self::createApi($requestSender, hubTransformer: $hubTransformer);

        // Second call for the same id is served from the cache without hitting the API.
        self::assertSame($hub, $api->getOneById('test-hub-id'));
        self::assertSame($hub, $api->getOneById('test-hub-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../hubdevices'])]
    public function testGetOneByIdEncodesId(string $hubId): void
    {
        $data = ['test-hub-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(HubApiInterface::API_URL_SPRINTF, rawurlencode($hubId)),
                [],
                self::authHeaders()
            )
            ->willReturn($data);

        $hub = self::createStub(HubInterface::class);

        $hubTransformer = self::createMock(HubTransformerInterface::class);
        $hubTransformer->expects(self::once())->method('transform')->with($data)->willReturn($hub);

        $api = self::createApi($requestSender, hubTransformer: $hubTransformer);

        self::assertSame($hub, $api->getOneById($hubId));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $hub = self::createStub(HubInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-hub-data']);

        $hubTransformer = self::createMock(HubTransformerInterface::class);
        $hubTransformer->expects(self::exactly(2))->method('transform')->willReturn($hub);

        $api = self::createApi($requestSender, hubTransformer: $hubTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($hub, $api->getOneById('test-hub-id'));
        self::assertSame($hub, $api->getOneById('test-hub-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetOneByIdUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = self::createApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(HubApiInterface::UNEXPECTED_RESPONSE);
        $api->getOneById('test-hub-id', $skipCache);
    }

    /**
     * @return array<string, string>
     */
    private static function authHeaders(): array
    {
        return [
            ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
        ];
    }

    /**
     * @throws Exception
     */
    private static function createApi(
        JsonApiRequestSenderInterface $requestSender,
        ?HubTransformerInterface $hubTransformer = null,
        ?HubCharacteristicsTransformerInterface $characteristicsTransformer = null,
        ?HubInstalledDriverTransformerInterface $driverTransformer = null,
        ?HubInstalledDriversTransformerInterface $driversTransformer = null,
        ?HubEnrolledChannelsTransformerInterface $channelsTransformer = null,
    ): HubApi {
        return new HubApi(
            $requestSender,
            $hubTransformer ?? self::createStub(HubTransformerInterface::class),
            $characteristicsTransformer ?? self::createStub(HubCharacteristicsTransformerInterface::class),
            $driverTransformer ?? self::createStub(HubInstalledDriverTransformerInterface::class),
            $driversTransformer ?? self::createStub(HubInstalledDriversTransformerInterface::class),
            $channelsTransformer ?? self::createStub(HubEnrolledChannelsTransformerInterface::class),
            new Token('test-api-token'),
        );
    }
}
