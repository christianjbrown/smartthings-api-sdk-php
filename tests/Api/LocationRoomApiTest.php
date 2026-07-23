<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\LocationRoomApi;
use ChristianBrown\SmartThings\Api\LocationRoomApiInterface;
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
#[CoversClass(Token::class)]
final class LocationRoomApiTest extends TestCase
{
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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'));

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

        $roomApi = new LocationRoomApi($requestSender, self::createStub(LocationRoomTransformerInterface::class), self::createStub(LocationRoomsTransformerInterface::class), $devicesTransformer, new Token('test-api-token'));
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

        $roomApi = new LocationRoomApi($requestSender, self::createStub(LocationRoomTransformerInterface::class), self::createStub(LocationRoomsTransformerInterface::class), $devicesTransformer, new Token('test-api-token'));

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

        $roomApi = new LocationRoomApi($requestSender, self::createStub(LocationRoomTransformerInterface::class), self::createStub(LocationRoomsTransformerInterface::class), $devicesTransformer, new Token('test-api-token'));
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

        $roomApi = new LocationRoomApi($requestSender, self::createStub(LocationRoomTransformerInterface::class), self::createStub(LocationRoomsTransformerInterface::class), $devicesTransformer, new Token('test-api-token'));

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

        $roomApi = new LocationRoomApi($requestSender, self::createStub(LocationRoomTransformerInterface::class), self::createStub(LocationRoomsTransformerInterface::class), self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'));

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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'));
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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'));

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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'));
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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'));

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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'));

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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'));
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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'));

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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'));

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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'));
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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'));
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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'));

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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, $roomsTransformer, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($room, $roomApi->getOneByDevice($device));
        self::assertSame($room, $roomApi->getOneByDevice($device, true));
    }
}
