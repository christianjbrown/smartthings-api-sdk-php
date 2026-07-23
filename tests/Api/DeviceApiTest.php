<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\DeviceApi;
use ChristianBrown\SmartThings\Api\DeviceApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Transformer\DevicesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;

use PHPUnit\Framework\TestCase;

use function rawurlencode;
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
        $requestSender->expects(self::once())->method('get')
            ->with(
                DeviceApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $devices = [self::createStub(DeviceInterface::class), self::createStub(DeviceInterface::class)];

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::once())->method('transform')
            ->with($data[DeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'));
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

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[DeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'));

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

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[DeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'));

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
        $requestSender->expects(self::once())->method('get')
            ->with(
                DeviceApiInterface::API_URL,
                [DeviceApiInterface::KEY_LOCATION_ID => 'test-location-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $devices = [self::createStub(DeviceInterface::class), self::createStub(DeviceInterface::class)];

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::once())->method('transform')
            ->with($data[DeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'));
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

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[DeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'));

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
        $requestSender->expects(self::once())->method('get')
            ->with(
                DeviceApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);
        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceApiInterface::UNEXPECTED_RESPONSE_SPRINTF, DeviceApiInterface::KEY_ITEMS));
        $deviceApi->getMultiple(null, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-device-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $device = self::createStub(DeviceInterface::class);

        $deviceTransformer = self::createMock(DeviceTransformerInterface::class);
        $deviceTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($device);

        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'));
        $actual = $deviceApi->getOneById('test-device-id');

        self::assertSame($device, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $data = ['test-device-data'];

        $device = self::createStub(DeviceInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                sprintf(DeviceApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $deviceTransformer = self::createMock(DeviceTransformerInterface::class);
        $deviceTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($device);

        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'));

        // Second call for the same deviceId is served from the cache without hitting the API.
        self::assertSame($device, $deviceApi->getOneById('test-device-id'));
        self::assertSame($device, $deviceApi->getOneById('test-device-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../devices'])]
    public function testGetOneByIdEncodesId(string $deviceId): void
    {
        $data = ['test-device-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceApiInterface::API_URL_SPRINTF, rawurlencode($deviceId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $device = self::createStub(DeviceInterface::class);

        $deviceTransformer = self::createMock(DeviceTransformerInterface::class);
        $deviceTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($device);

        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'));
        $actual = $deviceApi->getOneById($deviceId);

        self::assertSame($device, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $data = ['test-device-data'];

        $device = self::createStub(DeviceInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->with(
                sprintf(DeviceApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $deviceTransformer = self::createMock(DeviceTransformerInterface::class);
        $deviceTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($device);

        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($device, $deviceApi->getOneById('test-device-id'));
        self::assertSame($device, $deviceApi->getOneById('test-device-id', true));
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
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $deviceTransformer = self::createStub(DeviceTransformerInterface::class);
        $devicesTransformer = self::createStub(DevicesTransformerInterface::class);

        $deviceApi = new DeviceApi($requestSender, $deviceTransformer, $devicesTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DeviceApiInterface::UNEXPECTED_RESPONSE);
        $deviceApi->getOneById('test-device-id', $skipCache);
    }
}
