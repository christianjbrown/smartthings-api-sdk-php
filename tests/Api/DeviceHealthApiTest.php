<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\DeviceHealthApi;
use ChristianBrown\SmartThings\Api\DeviceHealthApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceHealthInterface;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Transformer\DeviceHealthTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;

use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(DeviceHealthApi::class)]
#[CoversClass(Token::class)]
final class DeviceHealthApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCachesByDeviceId(): void
    {
        $data = ['test-health-data'];

        $device = self::createStub(DeviceInterface::class);
        $device->method('getDeviceId')
            ->willReturn('test-device-id');

        $health = self::createStub(DeviceHealthInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $healthTransformer = self::createMock(DeviceHealthTransformerInterface::class);
        $healthTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($health);

        $healthApi = new DeviceHealthApi($requestSender, $healthTransformer, new Token('test-api-token'));

        // Second call for the same deviceId is served from the cache without hitting the API.
        self::assertSame($health, $healthApi->getOneByDevice($device));
        self::assertSame($health, $healthApi->getOneByDevice($device));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByDevice(): void
    {
        $data = ['test-health-data'];

        $device = self::createStub(DeviceInterface::class);
        $device->method('getDeviceId')
            ->willReturn('test-device-id');

        $health = self::createStub(DeviceHealthInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceHealthApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $healthTransformer = self::createMock(DeviceHealthTransformerInterface::class);
        $healthTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($health);

        $healthApi = new DeviceHealthApi($requestSender, $healthTransformer, new Token('test-api-token'));
        $actual = $healthApi->getOneByDevice($device);

        self::assertSame($health, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-health-data'];

        $health = self::createStub(DeviceHealthInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceHealthApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $healthTransformer = self::createMock(DeviceHealthTransformerInterface::class);
        $healthTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($health);

        $healthApi = new DeviceHealthApi($requestSender, $healthTransformer, new Token('test-api-token'));
        $actual = $healthApi->getOneById('test-device-id');

        self::assertSame($health, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../devices'])]
    public function testGetOneByIdEncodesId(string $deviceId): void
    {
        $data = ['test-health-data'];

        $health = self::createStub(DeviceHealthInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceHealthApiInterface::API_URL_SPRINTF, rawurlencode($deviceId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $healthTransformer = self::createMock(DeviceHealthTransformerInterface::class);
        $healthTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($health);

        $healthApi = new DeviceHealthApi($requestSender, $healthTransformer, new Token('test-api-token'));
        $actual = $healthApi->getOneById($deviceId);

        self::assertSame($health, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetSkipsCache(): void
    {
        $data = ['test-health-data'];

        $device = self::createStub(DeviceInterface::class);
        $device->method('getDeviceId')
            ->willReturn('test-device-id');

        $health = self::createStub(DeviceHealthInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $healthTransformer = self::createMock(DeviceHealthTransformerInterface::class);
        $healthTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($health);

        $healthApi = new DeviceHealthApi($requestSender, $healthTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($health, $healthApi->getOneByDevice($device));
        self::assertSame($health, $healthApi->getOneByDevice($device, true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetUnexpectedResponse(bool $skipCache): void
    {
        $device = self::createStub(DeviceInterface::class);
        $device->method('getDeviceId')
            ->willReturn('test-device-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceHealthApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $healthTransformer = self::createStub(DeviceHealthTransformerInterface::class);

        $healthApi = new DeviceHealthApi($requestSender, $healthTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DeviceHealthApiInterface::UNEXPECTED_RESPONSE);
        $healthApi->getOneByDevice($device, $skipCache);
    }
}
