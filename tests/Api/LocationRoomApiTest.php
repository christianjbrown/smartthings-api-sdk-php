<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\LocationRoomApi;
use ChristianBrown\SmartThings\Api\LocationRoomApiInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\MissingInputException;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Model\LocationRoomInterface;
use ChristianBrown\SmartThings\Transformer\DevicesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationRoomsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationRoomTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(LocationRoomApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
final class LocationRoomApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateRoom(): void
    {
        $data = ['test-room-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $room = self::createStub(LocationRoomInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                sprintf(LocationRoomApiInterface::API_URL_LIST_SPRINTF, 'test-location-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                [LocationRoomApiInterface::KEY_NAME => 'test-room-name']
            )
            ->willReturn($data);

        $roomTransformer = self::createMock(LocationRoomTransformerInterface::class);
        $roomTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($room);

        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());
        $actual = $roomApi->createRoom($location, 'test-room-name');

        self::assertSame($room, $actual);
    }

    /**
     * createRoom() invalidates the cached room list for this location, so a subsequent
     * getMultiple() call hits the API again instead of returning a stale list.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateRoomInvalidatesListCache(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $room = self::createStub(LocationRoomInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn([LocationRoomApiInterface::KEY_ITEMS => ['test-item']]);
        $requestSender->expects(self::once())->method('post')
            ->willReturn(['test-room-data']);

        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);
        $roomTransformer->method('transform')
            ->willReturn($room);

        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);
        $roomsTransformer->method('transform')
            ->willReturn([$room]);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());

        $roomApi->getMultiple($location);
        $roomApi->createRoom($location, 'test-room-name');
        $roomApi->getMultiple($location);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateRoomUnexpectedResponse(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);
        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(LocationRoomApiInterface::UNEXPECTED_RESPONSE);
        $roomApi->createRoom($location, 'test-room-name');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteRoom(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(
                sprintf(LocationRoomApiInterface::API_URL_SPRINTF, 'test-location-id', 'test-room-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);
        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());
        $roomApi->deleteRoom($location, 'test-room-id');

        $this->addToAssertionCount(1);
    }

    /**
     * deleteRoom() invalidates both the cached copy of this room and the cached room
     * list for this location, so subsequent lookups hit the API again.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteRoomInvalidatesCaches(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $room = self::createStub(LocationRoomInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn(['test-room-data']);
        $requestSender->expects(self::once())->method('delete')
            ->willReturn([]);

        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);
        $roomTransformer->method('transform')
            ->willReturn($room);

        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());

        $roomApi->getOneByLocationAndId($location, 'test-room-id');
        $roomApi->deleteRoom($location, 'test-room-id');
        $roomApi->getOneByLocationAndId($location, 'test-room-id');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCachesByRoomId(): void
    {
        $data = ['test-room-data'];

        $device = self::createStub(DeviceInterface::class);
        $device->method('getLocationId')
            ->willReturn('test-location-id');
        $device->method('getRoomId')
            ->willReturn('test-room-id');

        $room = self::createStub(LocationRoomInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                sprintf(LocationRoomApiInterface::API_URL_SPRINTF, 'test-location-id', 'test-room-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $roomTransformer = self::createMock(LocationRoomTransformerInterface::class);
        $roomTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($room);

        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());

        // Second call for the same roomId is served from the cache without hitting the API.
        self::assertSame($room, $roomApi->getOneByDevice($device));
        self::assertSame($room, $roomApi->getOneByDevice($device));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDevicesInRoom(): void
    {
        $data = [
            LocationRoomApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationRoomApiInterface::API_URL_DEVICES_SPRINTF, 'test-location-id', 'test-room-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $devices = [self::createStub(DeviceInterface::class), self::createStub(DeviceInterface::class)];

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::once())->method('transform')
            ->with($data[LocationRoomApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $roomApi = new LocationRoomApi($requestSender, self::createStub(LocationRoomTransformerInterface::class), self::createStub(LocationRoomsTransformerInterface::class), $devicesTransformer, new Token('test-api-token'), new RequestUrlBuilder());
        $actual = $roomApi->getDevicesInRoom($location, 'test-room-id');

        self::assertSame($devices, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDevicesInRoomCaches(): void
    {
        $data = [
            LocationRoomApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $devices = [self::createStub(DeviceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[LocationRoomApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $roomApi = new LocationRoomApi($requestSender, self::createStub(LocationRoomTransformerInterface::class), self::createStub(LocationRoomsTransformerInterface::class), $devicesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        // Second call for the same roomId is served from the cache without hitting the API.
        self::assertSame($devices, $roomApi->getDevicesInRoom($location, 'test-room-id'));
        self::assertSame($devices, $roomApi->getDevicesInRoom($location, 'test-room-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDevicesInRoomEncodesIds(): void
    {
        $data = [
            LocationRoomApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('a/b c');

        $devices = [self::createStub(DeviceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationRoomApiInterface::API_URL_DEVICES_SPRINTF, rawurlencode('a/b c'), rawurlencode('x/y z')),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::once())->method('transform')
            ->with($data[LocationRoomApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $roomApi = new LocationRoomApi($requestSender, self::createStub(LocationRoomTransformerInterface::class), self::createStub(LocationRoomsTransformerInterface::class), $devicesTransformer, new Token('test-api-token'), new RequestUrlBuilder());
        $actual = $roomApi->getDevicesInRoom($location, 'x/y z');

        self::assertSame($devices, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDevicesInRoomSkipsCache(): void
    {
        $data = [
            LocationRoomApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $devices = [self::createStub(DeviceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[LocationRoomApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $roomApi = new LocationRoomApi($requestSender, self::createStub(LocationRoomTransformerInterface::class), self::createStub(LocationRoomsTransformerInterface::class), $devicesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($devices, $roomApi->getDevicesInRoom($location, 'test-room-id'));
        self::assertSame($devices, $roomApi->getDevicesInRoom($location, 'test-room-id', true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[LocationRoomApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[LocationRoomApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetDevicesInRoomUnexpectedResponse(array $data, bool $skipCache): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationRoomApiInterface::API_URL_DEVICES_SPRINTF, 'test-location-id', 'test-room-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $roomApi = new LocationRoomApi($requestSender, self::createStub(LocationRoomTransformerInterface::class), self::createStub(LocationRoomsTransformerInterface::class), self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocationRoomApiInterface::UNEXPECTED_RESPONSE_SPRINTF, LocationRoomApiInterface::KEY_ITEMS));
        $roomApi->getDevicesInRoom($location, 'test-room-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            LocationRoomApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationRoomApiInterface::API_URL_LIST_SPRINTF, 'test-location-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $rooms = [self::createStub(LocationRoomInterface::class), self::createStub(LocationRoomInterface::class)];

        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);

        $roomsTransformer = self::createMock(LocationRoomsTransformerInterface::class);
        $roomsTransformer->expects(self::once())->method('transform')
            ->with($data[LocationRoomApiInterface::KEY_ITEMS])
            ->willReturn($rooms);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());
        $actual = $roomApi->getMultiple($location);

        self::assertSame($rooms, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            LocationRoomApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $rooms = [self::createStub(LocationRoomInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);

        $roomsTransformer = self::createMock(LocationRoomsTransformerInterface::class);
        $roomsTransformer->expects(self::once())
            ->method('transform')
            ->with($data[LocationRoomApiInterface::KEY_ITEMS])
            ->willReturn($rooms);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());

        // Second call for the same locationId is served from the cache without hitting the API.
        self::assertSame($rooms, $roomApi->getMultiple($location));
        self::assertSame($rooms, $roomApi->getMultiple($location));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleEncodesLocationId(): void
    {
        $data = [
            LocationRoomApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('a/b c');

        $rooms = [self::createStub(LocationRoomInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationRoomApiInterface::API_URL_LIST_SPRINTF, rawurlencode('a/b c')),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);

        $roomsTransformer = self::createMock(LocationRoomsTransformerInterface::class);
        $roomsTransformer->expects(self::once())->method('transform')
            ->with($data[LocationRoomApiInterface::KEY_ITEMS])
            ->willReturn($rooms);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());
        $actual = $roomApi->getMultiple($location);

        self::assertSame($rooms, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            LocationRoomApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $rooms = [self::createStub(LocationRoomInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);

        $roomsTransformer = self::createMock(LocationRoomsTransformerInterface::class);
        $roomsTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[LocationRoomApiInterface::KEY_ITEMS])
            ->willReturn($rooms);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($rooms, $roomApi->getMultiple($location));
        self::assertSame($rooms, $roomApi->getMultiple($location, true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[LocationRoomApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[LocationRoomApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationRoomApiInterface::API_URL_LIST_SPRINTF, 'test-location-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);
        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocationRoomApiInterface::UNEXPECTED_RESPONSE_SPRINTF, LocationRoomApiInterface::KEY_ITEMS));
        $roomApi->getMultiple($location, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByDevice(): void
    {
        $data = ['test-room-data'];

        $device = self::createStub(DeviceInterface::class);
        $device->method('getLocationId')
            ->willReturn('test-location-id');
        $device->method('getRoomId')
            ->willReturn('test-room-id');

        $room = self::createStub(LocationRoomInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationRoomApiInterface::API_URL_SPRINTF, 'test-location-id', 'test-room-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $roomTransformer = self::createMock(LocationRoomTransformerInterface::class);
        $roomTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($room);

        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());
        $actual = $roomApi->getOneByDevice($device);

        self::assertSame($room, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByDeviceMissingLocationId(): void
    {
        $device = self::createStub(DeviceInterface::class);
        $device->method('getLocationId')
            ->willReturn(null);

        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);
        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(LocationRoomApiInterface::MISSING_LOCATION_ID);
        $roomApi->getOneByDevice($device);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByDeviceMissingRoomId(): void
    {
        $device = self::createStub(DeviceInterface::class);
        $device->method('getLocationId')
            ->willReturn('test-location-id');
        $device->method('getRoomId')
            ->willReturn(null);

        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);
        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());

        $this->expectException(MissingInputException::class);
        $this->expectExceptionMessage(LocationRoomApiInterface::MISSING_ROOM_ID);
        $roomApi->getOneByDevice($device);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByLocationAndId(): void
    {
        $data = ['test-room-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $room = self::createStub(LocationRoomInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationRoomApiInterface::API_URL_SPRINTF, 'test-location-id', 'test-room-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $roomTransformer = self::createMock(LocationRoomTransformerInterface::class);
        $roomTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($room);

        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());
        $actual = $roomApi->getOneByLocationAndId($location, 'test-room-id');

        self::assertSame($room, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c', 'x/y z'])]
    #[TestWith(['../../locations', '../../rooms'])]
    public function testGetOneByLocationAndIdEncodesIds(string $locationId, string $roomId): void
    {
        $data = ['test-room-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn($locationId);

        $room = self::createStub(LocationRoomInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationRoomApiInterface::API_URL_SPRINTF, rawurlencode($locationId), rawurlencode($roomId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $roomTransformer = self::createMock(LocationRoomTransformerInterface::class);
        $roomTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($room);

        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());
        $actual = $roomApi->getOneByLocationAndId($location, $roomId);

        self::assertSame($room, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetOneUnexpectedResponse(bool $skipCache): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationRoomApiInterface::API_URL_SPRINTF, 'test-location-id', 'test-room-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);
        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(LocationRoomApiInterface::UNEXPECTED_RESPONSE);
        $roomApi->getOneByLocationAndId($location, 'test-room-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetSkipsCache(): void
    {
        $data = ['test-room-data'];

        $device = self::createStub(DeviceInterface::class);
        $device->method('getLocationId')
            ->willReturn('test-location-id');
        $device->method('getRoomId')
            ->willReturn('test-room-id');

        $room = self::createStub(LocationRoomInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->with(
                sprintf(LocationRoomApiInterface::API_URL_SPRINTF, 'test-location-id', 'test-room-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $roomTransformer = self::createMock(LocationRoomTransformerInterface::class);
        $roomTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($room);

        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($room, $roomApi->getOneByDevice($device));
        self::assertSame($room, $roomApi->getOneByDevice($device, true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateRoom(): void
    {
        $data = ['test-room-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $room = self::createStub(LocationRoomInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(LocationRoomApiInterface::API_URL_SPRINTF, 'test-location-id', 'test-room-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                [LocationRoomApiInterface::KEY_NAME => 'test-room-name']
            )
            ->willReturn($data);

        $roomTransformer = self::createMock(LocationRoomTransformerInterface::class);
        $roomTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($room);

        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());
        $actual = $roomApi->updateRoom($location, 'test-room-id', 'test-room-name');

        self::assertSame($room, $actual);
    }

    /**
     * updateRoom() refreshes the cached copy of this room, so a subsequent
     * getOneByLocationAndId() for the same id is served from it.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateRoomPopulatesCache(): void
    {
        $data = ['test-room-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $room = self::createStub(LocationRoomInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('put')
            ->willReturn($data);

        $roomTransformer = self::createMock(LocationRoomTransformerInterface::class);
        $roomTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($room);

        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());

        self::assertSame($room, $roomApi->updateRoom($location, 'test-room-id', 'test-room-name'));
        self::assertSame($room, $roomApi->getOneByLocationAndId($location, 'test-room-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateRoomUnexpectedResponse(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn([]);

        $roomTransformer = self::createStub(LocationRoomTransformerInterface::class);
        $roomsTransformer = self::createStub(LocationRoomsTransformerInterface::class);

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(LocationRoomApiInterface::UNEXPECTED_RESPONSE);
        $roomApi->updateRoom($location, 'test-room-id', 'test-room-name');
    }
}
