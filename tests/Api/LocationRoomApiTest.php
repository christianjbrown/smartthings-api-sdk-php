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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, new Token('test-api-token'));

        // Second call for the same roomId is served from the cache without hitting the API.
        self::assertSame($room, $roomApi->getOneByDevice($device));
        self::assertSame($room, $roomApi->getOneByDevice($device));
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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, new Token('test-api-token'));
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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, new Token('test-api-token'));

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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, new Token('test-api-token'));

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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, new Token('test-api-token'));
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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, new Token('test-api-token'));
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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, new Token('test-api-token'));

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

        $roomApi = new LocationRoomApi($requestSender, $roomTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($room, $roomApi->getOneByDevice($device));
        self::assertSame($room, $roomApi->getOneByDevice($device, true));
    }
}
