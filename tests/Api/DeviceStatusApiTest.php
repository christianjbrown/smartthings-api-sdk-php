<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Api\DeviceStatusApi;
use ChristianBrown\SmartThings\Api\DeviceStatusApiInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\DeviceStatusInterface;
use ChristianBrown\SmartThings\Transformer\DeviceStatusTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;

use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(DeviceStatusApi::class)]
#[CoversClass(Token::class)]
final class DeviceStatusApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCachesByDeviceId(): void
    {
        $data = [
            DeviceStatusApiInterface::KEY_COMPONENTS => [
                DeviceStatusApiInterface::KEY_COMPONENTS_MAIN => ['test-item-1', 'test-item-2'],
            ],
        ];

        $device = self::createStub(DeviceInterface::class);
        $device->method('getDeviceId')
            ->willReturn('test-device-id');

        $deviceStatus = self::createStub(DeviceStatusInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $deviceStatusTransformer = self::createMock(DeviceStatusTransformerInterface::class);
        $deviceStatusTransformer->expects(self::once())
            ->method('transform')
            ->with($data[DeviceStatusApiInterface::KEY_COMPONENTS][DeviceStatusApiInterface::KEY_COMPONENTS_MAIN])
            ->willReturn($deviceStatus);

        $deviceApi = new DeviceStatusApi($requestSender, $deviceStatusTransformer, new Token('test-api-token'));

        // Second call for the same deviceId is served from the cache without hitting the API.
        self::assertSame($deviceStatus, $deviceApi->getOneByDevice($device));
        self::assertSame($deviceStatus, $deviceApi->getOneByDevice($device));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByDevice(): void
    {
        $data = [
            DeviceStatusApiInterface::KEY_COMPONENTS => [
                DeviceStatusApiInterface::KEY_COMPONENTS_MAIN => ['test-item-1', 'test-item-2'],
            ],
        ];

        $device = self::createStub(DeviceInterface::class);
        $device->method('getDeviceId')
            ->willReturn('test-device-id');

        $deviceStatus = self::createStub(DeviceStatusInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceStatusApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $deviceStatusTransformer = self::createMock(DeviceStatusTransformerInterface::class);
        $deviceStatusTransformer->expects(self::once())->method('transform')
            ->with($data[DeviceStatusApiInterface::KEY_COMPONENTS][DeviceStatusApiInterface::KEY_COMPONENTS_MAIN])
            ->willReturn($deviceStatus);

        $deviceApi = new DeviceStatusApi($requestSender, $deviceStatusTransformer, new Token('test-api-token'));
        $actual = $deviceApi->getOneByDevice($device);

        self::assertSame($deviceStatus, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = [
            DeviceStatusApiInterface::KEY_COMPONENTS => [
                DeviceStatusApiInterface::KEY_COMPONENTS_MAIN => ['test-item-1', 'test-item-2'],
            ],
        ];

        $deviceStatus = self::createStub(DeviceStatusInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceStatusApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $deviceStatusTransformer = self::createMock(DeviceStatusTransformerInterface::class);
        $deviceStatusTransformer->expects(self::once())->method('transform')
            ->with($data[DeviceStatusApiInterface::KEY_COMPONENTS][DeviceStatusApiInterface::KEY_COMPONENTS_MAIN])
            ->willReturn($deviceStatus);

        $deviceApi = new DeviceStatusApi($requestSender, $deviceStatusTransformer, new Token('test-api-token'));
        $actual = $deviceApi->getOneById('test-device-id');

        self::assertSame($deviceStatus, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../locations'])]
    public function testGetOneByIdEncodesId(string $deviceId): void
    {
        $data = [
            DeviceStatusApiInterface::KEY_COMPONENTS => [
                DeviceStatusApiInterface::KEY_COMPONENTS_MAIN => ['test-item-1', 'test-item-2'],
            ],
        ];

        $deviceStatus = self::createStub(DeviceStatusInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceStatusApiInterface::API_URL_SPRINTF, rawurlencode($deviceId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $deviceStatusTransformer = self::createMock(DeviceStatusTransformerInterface::class);
        $deviceStatusTransformer->expects(self::once())->method('transform')
            ->with($data[DeviceStatusApiInterface::KEY_COMPONENTS][DeviceStatusApiInterface::KEY_COMPONENTS_MAIN])
            ->willReturn($deviceStatus);

        $deviceApi = new DeviceStatusApi($requestSender, $deviceStatusTransformer, new Token('test-api-token'));
        $actual = $deviceApi->getOneById($deviceId);

        self::assertSame($deviceStatus, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetSkipsCache(): void
    {
        $data = [
            DeviceStatusApiInterface::KEY_COMPONENTS => [
                DeviceStatusApiInterface::KEY_COMPONENTS_MAIN => ['test-item-1', 'test-item-2'],
            ],
        ];

        $device = self::createStub(DeviceInterface::class);
        $device->method('getDeviceId')
            ->willReturn('test-device-id');

        $deviceStatus = self::createStub(DeviceStatusInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $deviceStatusTransformer = self::createMock(DeviceStatusTransformerInterface::class);
        $deviceStatusTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[DeviceStatusApiInterface::KEY_COMPONENTS][DeviceStatusApiInterface::KEY_COMPONENTS_MAIN])
            ->willReturn($deviceStatus);

        $deviceApi = new DeviceStatusApi($requestSender, $deviceStatusTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($deviceStatus, $deviceApi->getOneByDevice($device));
        self::assertSame($deviceStatus, $deviceApi->getOneByDevice($device, true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], DeviceStatusApiInterface::KEY_COMPONENTS, false])]
    #[TestWith([[DeviceStatusApiInterface::KEY_COMPONENTS => 'test-not-array'], DeviceStatusApiInterface::KEY_COMPONENTS, false])]
    #[TestWith([[DeviceStatusApiInterface::KEY_COMPONENTS => ['test-items-key-missing']], DeviceStatusApiInterface::KEY_COMPONENTS_MAIN, false])]
    #[TestWith([[DeviceStatusApiInterface::KEY_COMPONENTS => [DeviceStatusApiInterface::KEY_COMPONENTS_MAIN => 'test-not-array']], DeviceStatusApiInterface::KEY_COMPONENTS_MAIN, false])]
    #[TestWith([['test-items-key-missing'], DeviceStatusApiInterface::KEY_COMPONENTS, true])]
    #[TestWith([[DeviceStatusApiInterface::KEY_COMPONENTS => 'test-not-array'], DeviceStatusApiInterface::KEY_COMPONENTS, true])]
    #[TestWith([[DeviceStatusApiInterface::KEY_COMPONENTS => ['test-items-key-missing']], DeviceStatusApiInterface::KEY_COMPONENTS_MAIN, true])]
    #[TestWith([[DeviceStatusApiInterface::KEY_COMPONENTS => [DeviceStatusApiInterface::KEY_COMPONENTS_MAIN => 'test-not-array']], DeviceStatusApiInterface::KEY_COMPONENTS_MAIN, true])]
    public function testGetUnexpectedResponse(array $data, string $exceptionString, bool $skipCache): void
    {
        $device = self::createStub(DeviceInterface::class);
        $device->method('getDeviceId')
            ->willReturn('test-device-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceStatusApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $deviceStatusTransformer = self::createStub(DeviceStatusTransformerInterface::class);

        $deviceApi = new DeviceStatusApi($requestSender, $deviceStatusTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceStatusApiInterface::UNEXPECTED_RESPONSE_SPRINTF, $exceptionString));
        $deviceApi->getOneByDevice($device, $skipCache);
    }
}
