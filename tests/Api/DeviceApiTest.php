<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Api\DeviceApi;
use ChristianBrown\SmartThings\Api\DeviceApiInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Transformer\DevicesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;

use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DeviceApi::class)]
#[CoversClass(Token::class)]
final class DeviceApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            DeviceApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')
            ->with(
                DeviceApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $devices = [self::createStub(DeviceInterface::class), self::createStub(DeviceInterface::class)];

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->method('transform')
            ->with($data[DeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $deviceApi = new DeviceApi($requestSender, $devicesTransformer, new Token('test-api-token'));
        $actual = $deviceApi->getMultiple();

        self::assertSame($devices, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            DeviceApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $devices = [self::createStub(DeviceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[DeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $deviceApi = new DeviceApi($requestSender, $devicesTransformer, new Token('test-api-token'));

        // Second call is served from the cache without hitting the API.
        self::assertSame($devices, $deviceApi->getMultiple());
        self::assertSame($devices, $deviceApi->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCachesPerLocation(): void
    {
        $data = [
            DeviceApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $devices = [self::createStub(DeviceInterface::class)];

        // A distinct locationId is a distinct cache key, so it hits the API again.
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->method('transform')
            ->with($data[DeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $deviceApi = new DeviceApi($requestSender, $devicesTransformer, new Token('test-api-token'));

        self::assertSame($devices, $deviceApi->getMultiple('test-location-a'));
        self::assertSame($devices, $deviceApi->getMultiple('test-location-b'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleFiltersByLocation(): void
    {
        $data = [
            DeviceApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')
            ->with(
                DeviceApiInterface::API_URL,
                [DeviceApiInterface::KEY_LOCATION_ID => 'test-location-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $devices = [self::createStub(DeviceInterface::class), self::createStub(DeviceInterface::class)];

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->method('transform')
            ->with($data[DeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $deviceApi = new DeviceApi($requestSender, $devicesTransformer, new Token('test-api-token'));
        $actual = $deviceApi->getMultiple('test-location-id');

        self::assertSame($devices, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            DeviceApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $devices = [self::createStub(DeviceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->method('transform')
            ->with($data[DeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $deviceApi = new DeviceApi($requestSender, $devicesTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($devices, $deviceApi->getMultiple());
        self::assertSame($devices, $deviceApi->getMultiple(null, true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[DeviceApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[DeviceApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')
            ->with(
                DeviceApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $devicesTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceApiInterface::UNEXPECTED_RESPONSE_SPRINTF, DeviceApiInterface::KEY_ITEMS));
        $deviceApi->getMultiple(null, $skipCache);
    }
}
