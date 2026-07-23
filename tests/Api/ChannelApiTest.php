<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\ChannelApi;
use ChristianBrown\SmartThings\Api\ChannelApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ChannelDriverInterface;
use ChristianBrown\SmartThings\Model\ChannelInterface;
use ChristianBrown\SmartThings\Model\DriverInterface;
use ChristianBrown\SmartThings\Transformer\ChannelDriversTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ChannelsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ChannelTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DriverTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(ChannelApi::class)]
#[CoversClass(Token::class)]
final class ChannelApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDriverMeta(): void
    {
        $data = ['test-driver-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(ChannelApiInterface::API_URL_DRIVER_META_SPRINTF, 'test-channel-id', 'test-driver-id'),
                [],
                self::authHeaders()
            )
            ->willReturn($data);

        $driver = self::createStub(DriverInterface::class);

        $driverTransformer = self::createMock(DriverTransformerInterface::class);
        $driverTransformer->expects(self::once())->method('transform')->with($data)->willReturn($driver);

        $api = self::createApi($requestSender, driverTransformer: $driverTransformer);

        self::assertSame($driver, $api->getDriverMeta('test-channel-id', 'test-driver-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDriverMetaCaches(): void
    {
        $driver = self::createStub(DriverInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-driver-data']);

        $driverTransformer = self::createMock(DriverTransformerInterface::class);
        $driverTransformer->expects(self::once())->method('transform')->willReturn($driver);

        $api = self::createApi($requestSender, driverTransformer: $driverTransformer);

        // Second call for the same channel and driver is served from the cache without hitting the API.
        self::assertSame($driver, $api->getDriverMeta('test-channel-id', 'test-driver-id'));
        self::assertSame($driver, $api->getDriverMeta('test-channel-id', 'test-driver-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c', 'x/y z'])]
    #[TestWith(['../../distchannels', '../../drivers'])]
    public function testGetDriverMetaEncodesIds(string $channelId, string $driverId): void
    {
        $data = ['test-driver-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(ChannelApiInterface::API_URL_DRIVER_META_SPRINTF, rawurlencode($channelId), rawurlencode($driverId)),
                [],
                self::authHeaders()
            )
            ->willReturn($data);

        $driver = self::createStub(DriverInterface::class);

        $driverTransformer = self::createMock(DriverTransformerInterface::class);
        $driverTransformer->expects(self::once())->method('transform')->with($data)->willReturn($driver);

        $api = self::createApi($requestSender, driverTransformer: $driverTransformer);

        self::assertSame($driver, $api->getDriverMeta($channelId, $driverId));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDriverMetaSkipsCache(): void
    {
        $driver = self::createStub(DriverInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-driver-data']);

        $driverTransformer = self::createMock(DriverTransformerInterface::class);
        $driverTransformer->expects(self::exactly(2))->method('transform')->willReturn($driver);

        $api = self::createApi($requestSender, driverTransformer: $driverTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($driver, $api->getDriverMeta('test-channel-id', 'test-driver-id'));
        self::assertSame($driver, $api->getDriverMeta('test-channel-id', 'test-driver-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetDriverMetaUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = self::createApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ChannelApiInterface::UNEXPECTED_RESPONSE);
        $api->getDriverMeta('test-channel-id', 'test-driver-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDrivers(): void
    {
        $data = [
            ChannelApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(ChannelApiInterface::API_URL_DRIVERS_SPRINTF, 'test-channel-id'),
                [],
                self::authHeaders()
            )
            ->willReturn($data);

        $channelDrivers = [self::createStub(ChannelDriverInterface::class)];

        $channelDriversTransformer = self::createMock(ChannelDriversTransformerInterface::class);
        $channelDriversTransformer->expects(self::once())->method('transform')
            ->with($data[ChannelApiInterface::KEY_ITEMS])
            ->willReturn($channelDrivers);

        $api = self::createApi($requestSender, channelDriversTransformer: $channelDriversTransformer);

        self::assertSame($channelDrivers, $api->getDrivers('test-channel-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDriversCaches(): void
    {
        $channelDrivers = [self::createStub(ChannelDriverInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([ChannelApiInterface::KEY_ITEMS => ['test-item-1']]);

        $channelDriversTransformer = self::createMock(ChannelDriversTransformerInterface::class);
        $channelDriversTransformer->expects(self::once())->method('transform')->willReturn($channelDrivers);

        $api = self::createApi($requestSender, channelDriversTransformer: $channelDriversTransformer);

        // Second call for the same channel is served from the cache without hitting the API.
        self::assertSame($channelDrivers, $api->getDrivers('test-channel-id'));
        self::assertSame($channelDrivers, $api->getDrivers('test-channel-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDriversSkipsCache(): void
    {
        $channelDrivers = [self::createStub(ChannelDriverInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn([ChannelApiInterface::KEY_ITEMS => ['test-item-1']]);

        $channelDriversTransformer = self::createMock(ChannelDriversTransformerInterface::class);
        $channelDriversTransformer->expects(self::exactly(2))->method('transform')->willReturn($channelDrivers);

        $api = self::createApi($requestSender, channelDriversTransformer: $channelDriversTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($channelDrivers, $api->getDrivers('test-channel-id'));
        self::assertSame($channelDrivers, $api->getDrivers('test-channel-id', true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[ChannelApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[ChannelApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetDriversUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn($data);

        $api = self::createApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ChannelApiInterface::UNEXPECTED_RESPONSE_SPRINTF, ChannelApiInterface::KEY_ITEMS));
        $api->getDrivers('test-channel-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            ChannelApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(ChannelApiInterface::API_URL, [], self::authHeaders())
            ->willReturn($data);

        $channels = [self::createStub(ChannelInterface::class), self::createStub(ChannelInterface::class)];

        $channelsTransformer = self::createMock(ChannelsTransformerInterface::class);
        $channelsTransformer->expects(self::once())->method('transform')
            ->with($data[ChannelApiInterface::KEY_ITEMS])
            ->willReturn($channels);

        $api = self::createApi($requestSender, channelsTransformer: $channelsTransformer);

        self::assertSame($channels, $api->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $channels = [self::createStub(ChannelInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([ChannelApiInterface::KEY_ITEMS => ['test-item-1']]);

        $channelsTransformer = self::createMock(ChannelsTransformerInterface::class);
        $channelsTransformer->expects(self::once())->method('transform')->willReturn($channels);

        $api = self::createApi($requestSender, channelsTransformer: $channelsTransformer);

        // Second call with the same filters is served from the cache without hitting the API.
        self::assertSame($channels, $api->getMultiple('DRIVER'));
        self::assertSame($channels, $api->getMultiple('DRIVER'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleIncludeReadOnlyFalse(): void
    {
        $data = [
            ChannelApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                ChannelApiInterface::API_URL,
                [ChannelApiInterface::KEY_INCLUDE_READ_ONLY => 'false'],
                self::authHeaders()
            )
            ->willReturn($data);

        $channels = [self::createStub(ChannelInterface::class)];

        $channelsTransformer = self::createMock(ChannelsTransformerInterface::class);
        $channelsTransformer->expects(self::once())->method('transform')->willReturn($channels);

        $api = self::createApi($requestSender, channelsTransformer: $channelsTransformer);

        self::assertSame($channels, $api->getMultiple(null, null, false));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $channels = [self::createStub(ChannelInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn([ChannelApiInterface::KEY_ITEMS => ['test-item-1']]);

        $channelsTransformer = self::createMock(ChannelsTransformerInterface::class);
        $channelsTransformer->expects(self::exactly(2))->method('transform')->willReturn($channels);

        $api = self::createApi($requestSender, channelsTransformer: $channelsTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($channels, $api->getMultiple());
        self::assertSame($channels, $api->getMultiple(null, null, null, true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[ChannelApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[ChannelApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn($data);

        $api = self::createApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ChannelApiInterface::UNEXPECTED_RESPONSE_SPRINTF, ChannelApiInterface::KEY_ITEMS));
        $api->getMultiple(null, null, null, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleWithFilters(): void
    {
        $data = [
            ChannelApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                ChannelApiInterface::API_URL,
                [
                    ChannelApiInterface::KEY_TYPE => 'DRIVER',
                    ChannelApiInterface::KEY_SUBSCRIBER_ID => 'test-subscriber-id',
                    ChannelApiInterface::KEY_INCLUDE_READ_ONLY => 'true',
                ],
                self::authHeaders()
            )
            ->willReturn($data);

        $channels = [self::createStub(ChannelInterface::class)];

        $channelsTransformer = self::createMock(ChannelsTransformerInterface::class);
        $channelsTransformer->expects(self::once())->method('transform')->willReturn($channels);

        $api = self::createApi($requestSender, channelsTransformer: $channelsTransformer);

        self::assertSame($channels, $api->getMultiple('DRIVER', 'test-subscriber-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-channel-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(ChannelApiInterface::API_URL_SPRINTF, 'test-channel-id'),
                [],
                self::authHeaders()
            )
            ->willReturn($data);

        $channel = self::createStub(ChannelInterface::class);

        $channelTransformer = self::createMock(ChannelTransformerInterface::class);
        $channelTransformer->expects(self::once())->method('transform')->with($data)->willReturn($channel);

        $api = self::createApi($requestSender, channelTransformer: $channelTransformer);

        self::assertSame($channel, $api->getOneById('test-channel-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $channel = self::createStub(ChannelInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-channel-data']);

        $channelTransformer = self::createMock(ChannelTransformerInterface::class);
        $channelTransformer->expects(self::once())->method('transform')->willReturn($channel);

        $api = self::createApi($requestSender, channelTransformer: $channelTransformer);

        // Second call for the same id is served from the cache without hitting the API.
        self::assertSame($channel, $api->getOneById('test-channel-id'));
        self::assertSame($channel, $api->getOneById('test-channel-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../distchannels'])]
    public function testGetOneByIdEncodesId(string $channelId): void
    {
        $data = ['test-channel-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(ChannelApiInterface::API_URL_SPRINTF, rawurlencode($channelId)),
                [],
                self::authHeaders()
            )
            ->willReturn($data);

        $channel = self::createStub(ChannelInterface::class);

        $channelTransformer = self::createMock(ChannelTransformerInterface::class);
        $channelTransformer->expects(self::once())->method('transform')->with($data)->willReturn($channel);

        $api = self::createApi($requestSender, channelTransformer: $channelTransformer);

        self::assertSame($channel, $api->getOneById($channelId));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $channel = self::createStub(ChannelInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-channel-data']);

        $channelTransformer = self::createMock(ChannelTransformerInterface::class);
        $channelTransformer->expects(self::exactly(2))->method('transform')->willReturn($channel);

        $api = self::createApi($requestSender, channelTransformer: $channelTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($channel, $api->getOneById('test-channel-id'));
        self::assertSame($channel, $api->getOneById('test-channel-id', true));
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
        $this->expectExceptionMessage(ChannelApiInterface::UNEXPECTED_RESPONSE);
        $api->getOneById('test-channel-id', $skipCache);
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
        ?ChannelTransformerInterface $channelTransformer = null,
        ?ChannelsTransformerInterface $channelsTransformer = null,
        ?ChannelDriversTransformerInterface $channelDriversTransformer = null,
        ?DriverTransformerInterface $driverTransformer = null,
    ): ChannelApi {
        return new ChannelApi(
            $requestSender,
            $channelTransformer ?? self::createStub(ChannelTransformerInterface::class),
            $channelsTransformer ?? self::createStub(ChannelsTransformerInterface::class),
            $channelDriversTransformer ?? self::createStub(ChannelDriversTransformerInterface::class),
            $driverTransformer ?? self::createStub(DriverTransformerInterface::class),
            new Token('test-api-token'),
        );
    }
}
