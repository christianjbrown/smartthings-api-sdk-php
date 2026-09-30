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
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Model\LocationRoomInterface;
use ChristianBrown\SmartThings\Transformer\DevicesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationRoomsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationRoomTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(LocationRoomApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
final class LocationRoomApiQueryParametersTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateRoomSendsAllowed(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(sprintf(LocationRoomApiInterface::API_URL_LIST_SPRINTF, 'test-location-id').'?allowed=true', [], $this->headers(), [LocationRoomApiInterface::KEY_NAME => 'Kitchen'])
            ->willReturn(['test-data']);
        $room = self::createStub(LocationRoomInterface::class);
        $transformer = self::createStub(LocationRoomTransformerInterface::class);
        $transformer->method('transform')->willReturn($room);
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')->willReturn('test-location-id');
        $api = $this->api($requestSender, roomTransformer: $transformer);

        self::assertSame($room, $api->createRoom($location, 'Kitchen', true));
    }

    private function api(JsonApiRequestSenderInterface $requestSender, ?LocationRoomTransformerInterface $roomTransformer = null, ?LocationRoomsTransformerInterface $roomsTransformer = null, ?DevicesTransformerInterface $devicesTransformer = null): LocationRoomApi
    {
        return new LocationRoomApi($requestSender, $roomTransformer ?? self::createStub(LocationRoomTransformerInterface::class), $roomsTransformer ?? self::createStub(LocationRoomsTransformerInterface::class), $devicesTransformer ?? self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'), new RequestUrlBuilder());
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
