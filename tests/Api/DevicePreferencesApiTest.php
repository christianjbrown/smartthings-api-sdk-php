<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\DevicePreferencesApi;
use ChristianBrown\SmartThings\Api\DevicePreferencesApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\DevicePreferenceInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferencesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(DevicePreferencesApi::class)]
#[CoversClass(Token::class)]
final class DevicePreferencesApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCachesByDeviceId(): void
    {
        $data = ['test-preferences-data'];

        $device = self::createStub(DeviceInterface::class);
        $device->method('getDeviceId')
            ->willReturn('test-device-id');

        $preferences = [self::createStub(DevicePreferenceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $preferencesTransformer = self::createMock(DevicePreferencesTransformerInterface::class);
        $preferencesTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($preferences);

        $preferencesApi = new DevicePreferencesApi($requestSender, $preferencesTransformer, new Token('test-api-token'));

        // Second call for the same deviceId is served from the cache without hitting the API.
        self::assertSame($preferences, $preferencesApi->getOneByDevice($device));
        self::assertSame($preferences, $preferencesApi->getOneByDevice($device));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByDevice(): void
    {
        $data = ['test-preferences-data'];

        $device = self::createStub(DeviceInterface::class);
        $device->method('getDeviceId')
            ->willReturn('test-device-id');

        $preferences = [self::createStub(DevicePreferenceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DevicePreferencesApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $preferencesTransformer = self::createMock(DevicePreferencesTransformerInterface::class);
        $preferencesTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($preferences);

        $preferencesApi = new DevicePreferencesApi($requestSender, $preferencesTransformer, new Token('test-api-token'));
        $actual = $preferencesApi->getOneByDevice($device);

        self::assertSame($preferences, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-preferences-data'];

        $preferences = [self::createStub(DevicePreferenceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DevicePreferencesApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $preferencesTransformer = self::createMock(DevicePreferencesTransformerInterface::class);
        $preferencesTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($preferences);

        $preferencesApi = new DevicePreferencesApi($requestSender, $preferencesTransformer, new Token('test-api-token'));
        $actual = $preferencesApi->getOneById('test-device-id');

        self::assertSame($preferences, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../devices'])]
    public function testGetOneByIdEncodesId(string $deviceId): void
    {
        $data = ['test-preferences-data'];

        $preferences = [self::createStub(DevicePreferenceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DevicePreferencesApiInterface::API_URL_SPRINTF, rawurlencode($deviceId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $preferencesTransformer = self::createMock(DevicePreferencesTransformerInterface::class);
        $preferencesTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($preferences);

        $preferencesApi = new DevicePreferencesApi($requestSender, $preferencesTransformer, new Token('test-api-token'));
        $actual = $preferencesApi->getOneById($deviceId);

        self::assertSame($preferences, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetSkipsCache(): void
    {
        $data = ['test-preferences-data'];

        $device = self::createStub(DeviceInterface::class);
        $device->method('getDeviceId')
            ->willReturn('test-device-id');

        $preferences = [self::createStub(DevicePreferenceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $preferencesTransformer = self::createMock(DevicePreferencesTransformerInterface::class);
        $preferencesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($preferences);

        $preferencesApi = new DevicePreferencesApi($requestSender, $preferencesTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($preferences, $preferencesApi->getOneByDevice($device));
        self::assertSame($preferences, $preferencesApi->getOneByDevice($device, true));
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
                sprintf(DevicePreferencesApiInterface::API_URL_SPRINTF, 'test-device-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $preferencesTransformer = self::createStub(DevicePreferencesTransformerInterface::class);

        $preferencesApi = new DevicePreferencesApi($requestSender, $preferencesTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DevicePreferencesApiInterface::UNEXPECTED_RESPONSE);
        $preferencesApi->getOneByDevice($device, $skipCache);
    }
}
