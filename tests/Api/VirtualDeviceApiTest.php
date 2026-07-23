<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Api\VirtualDeviceApi;
use ChristianBrown\SmartThings\Api\VirtualDeviceApiInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Transformer\DevicesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(VirtualDeviceApi::class)]
#[CoversClass(Token::class)]
final class VirtualDeviceApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            VirtualDeviceApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                VirtualDeviceApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $devices = [self::createStub(DeviceInterface::class), self::createStub(DeviceInterface::class)];

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::once())->method('transform')
            ->with($data[VirtualDeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $virtualDeviceApi = new VirtualDeviceApi($requestSender, $devicesTransformer, new Token('test-api-token'));
        $actual = $virtualDeviceApi->getMultiple();

        self::assertSame($devices, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            VirtualDeviceApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $devices = [self::createStub(DeviceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[VirtualDeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $virtualDeviceApi = new VirtualDeviceApi($requestSender, $devicesTransformer, new Token('test-api-token'));

        // Second call with the same filter is served from the cache without hitting the API.
        self::assertSame($devices, $virtualDeviceApi->getMultiple());
        self::assertSame($devices, $virtualDeviceApi->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleFiltersByLocation(): void
    {
        $data = [
            VirtualDeviceApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                VirtualDeviceApiInterface::API_URL,
                [VirtualDeviceApiInterface::KEY_LOCATION_ID => 'test-location-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $devices = [self::createStub(DeviceInterface::class)];

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::once())->method('transform')
            ->with($data[VirtualDeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $virtualDeviceApi = new VirtualDeviceApi($requestSender, $devicesTransformer, new Token('test-api-token'));
        $actual = $virtualDeviceApi->getMultiple('test-location-id');

        self::assertSame($devices, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            VirtualDeviceApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $devices = [self::createStub(DeviceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $devicesTransformer = self::createMock(DevicesTransformerInterface::class);
        $devicesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[VirtualDeviceApiInterface::KEY_ITEMS])
            ->willReturn($devices);

        $virtualDeviceApi = new VirtualDeviceApi($requestSender, $devicesTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($devices, $virtualDeviceApi->getMultiple());
        self::assertSame($devices, $virtualDeviceApi->getMultiple(null, true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[VirtualDeviceApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[VirtualDeviceApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                VirtualDeviceApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $virtualDeviceApi = new VirtualDeviceApi($requestSender, self::createStub(DevicesTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(VirtualDeviceApiInterface::UNEXPECTED_RESPONSE_SPRINTF, VirtualDeviceApiInterface::KEY_ITEMS));
        $virtualDeviceApi->getMultiple(null, $skipCache);
    }
}
