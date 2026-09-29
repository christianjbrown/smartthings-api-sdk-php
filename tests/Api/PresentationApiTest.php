<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\PresentationApi;
use ChristianBrown\SmartThings\Api\PresentationApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CreateDeviceConfigRequestInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationRequestInterface;
use ChristianBrown\SmartThings\Model\DeviceInterface;
use ChristianBrown\SmartThings\Model\DevicePresentationInterface;
use ChristianBrown\SmartThings\Model\PresentationInterface;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\CreateDeviceConfigRequestTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DevicePresentationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PresentationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(PresentationApi::class)]
#[CoversClass(Token::class)]
final class PresentationApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateDeviceConfiguration(): void
    {
        $data = ['test-data'];

        $request = self::createStub(DeviceConfigurationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                PresentationApiInterface::API_URL_DEVICE_CONFIG,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(DeviceConfigurationRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(DeviceConfigurationInterface::class);

        $transformer = self::createMock(DeviceConfigurationTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), $serializer, $transformer, self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));
        $actual = $api->createDeviceConfiguration($request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateDeviceConfigurationUnexpectedResponse(): void
    {
        $request = self::createStub(DeviceConfigurationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PresentationApiInterface::UNEXPECTED_RESPONSE);
        $api->createDeviceConfiguration($request);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGenerateDeviceConfiguration(): void
    {
        $data = ['test-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(PresentationApiInterface::API_URL_TYPE_DEVICE_CONFIG_SPRINTF, 'test-type-integration-id'),
                [PresentationApiInterface::KEY_TYPE_INTEGRATION => 'test-type-integration', PresentationApiInterface::KEY_TYPE_SHARD_ID => 'test-type-shard-id', PresentationApiInterface::KEY_EXCLUDE_UNDISPLAYABLE_CAPABILITIES_FROM_PRESENTATION => 'true'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $model = self::createStub(CreateDeviceConfigRequestInterface::class);

        $transformer = self::createMock(CreateDeviceConfigRequestTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), $transformer);
        $actual = $api->generateDeviceConfiguration('test-type-integration-id', 'test-type-integration', 'test-type-shard-id', true);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGenerateDeviceConfigurationCaches(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-data']);

        $transformer = self::createMock(CreateDeviceConfigRequestTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')->willReturn(self::createStub(CreateDeviceConfigRequestInterface::class));

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), $transformer);

        // Second call for the same key is served from the cache without hitting the API.
        $api->generateDeviceConfiguration('test-type-integration-id');
        $api->generateDeviceConfiguration('test-type-integration-id');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGenerateDeviceConfigurationSkipsCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-data']);

        $transformer = self::createMock(CreateDeviceConfigRequestTransformerInterface::class);
        $transformer->expects(self::exactly(2))->method('transform')->willReturn(self::createStub(CreateDeviceConfigRequestInterface::class));

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), $transformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        $api->generateDeviceConfiguration('test-type-integration-id');
        $api->generateDeviceConfiguration('test-type-integration-id', skipCache: true);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGenerateDeviceConfigurationUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PresentationApiInterface::UNEXPECTED_RESPONSE);
        $api->generateDeviceConfiguration('test-type-integration-id', skipCache: $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGenerateDeviceConfigurationWithoutOptionalParameters(): void
    {
        $data = ['test-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(PresentationApiInterface::API_URL_TYPE_DEVICE_CONFIG_SPRINTF, 'test-type-integration-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $model = self::createStub(CreateDeviceConfigRequestInterface::class);

        $transformer = self::createMock(CreateDeviceConfigRequestTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), $transformer);
        $actual = $api->generateDeviceConfiguration('test-type-integration-id');

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetByDevice(): void
    {
        $data = ['test-presentation-data'];

        $device = self::createStub(DeviceInterface::class);
        $device->method('getDeviceId')
            ->willReturn('test-device-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                PresentationApiInterface::API_URL,
                [PresentationApiInterface::KEY_DEVICE_ID => 'test-device-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $presentation = self::createStub(PresentationInterface::class);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));
        $actual = $presentationApi->getByDevice($device);

        self::assertSame($presentation, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetByDeviceIdCaches(): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(PresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        // Second call for the same device id is served from the cache without hitting the API.
        self::assertSame($presentation, $presentationApi->getByDeviceId('test-device-id'));
        self::assertSame($presentation, $presentationApi->getByDeviceId('test-device-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetByDeviceIdSkipsCache(): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(PresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($presentation, $presentationApi->getByDeviceId('test-device-id'));
        self::assertSame($presentation, $presentationApi->getByDeviceId('test-device-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDeviceConfig(): void
    {
        $data = ['test-presentation-data'];

        // Without a manufacturerName the query carries only the presentationId.
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                PresentationApiInterface::API_URL_DEVICE_CONFIG,
                [PresentationApiInterface::KEY_PRESENTATION_ID => 'test-presentation-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $presentation = self::createStub(PresentationInterface::class);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));
        $actual = $presentationApi->getDeviceConfig('test-presentation-id');

        self::assertSame($presentation, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDeviceConfigByType(): void
    {
        $data = ['test-presentation-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(PresentationApiInterface::API_URL_TYPE_DEVICE_CONFIG_SPRINTF, 'test-type-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $presentation = self::createStub(PresentationInterface::class);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));
        $actual = $presentationApi->getDeviceConfigByType('test-type-id');

        self::assertSame($presentation, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDeviceConfigByTypeCaches(): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(PresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        // Second call for the same type id is served from the cache without hitting the API.
        self::assertSame($presentation, $presentationApi->getDeviceConfigByType('test-type-id'));
        self::assertSame($presentation, $presentationApi->getDeviceConfigByType('test-type-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../presentation'])]
    public function testGetDeviceConfigByTypeEncodesId(string $typeIntegrationId): void
    {
        $data = ['test-presentation-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(PresentationApiInterface::API_URL_TYPE_DEVICE_CONFIG_SPRINTF, rawurlencode($typeIntegrationId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $presentation = self::createStub(PresentationInterface::class);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));
        $actual = $presentationApi->getDeviceConfigByType($typeIntegrationId);

        self::assertSame($presentation, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDeviceConfigByTypeSkipsCache(): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(PresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($presentation, $presentationApi->getDeviceConfigByType('test-type-id'));
        self::assertSame($presentation, $presentationApi->getDeviceConfigByType('test-type-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetDeviceConfigByTypeUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn([]);

        $presentationTransformer = self::createStub(PresentationTransformerInterface::class);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PresentationApiInterface::UNEXPECTED_RESPONSE);
        $presentationApi->getDeviceConfigByType('test-type-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDeviceConfigCaches(): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(PresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        // Second call for the same key is served from the cache without hitting the API.
        self::assertSame($presentation, $presentationApi->getDeviceConfig('test-presentation-id'));
        self::assertSame($presentation, $presentationApi->getDeviceConfig('test-presentation-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDeviceConfigSkipsCache(): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(PresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($presentation, $presentationApi->getDeviceConfig('test-presentation-id'));
        self::assertSame($presentation, $presentationApi->getDeviceConfig('test-presentation-id', null, true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetDeviceConfigUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn([]);

        $presentationTransformer = self::createStub(PresentationTransformerInterface::class);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PresentationApiInterface::UNEXPECTED_RESPONSE);
        $presentationApi->getDeviceConfig('test-presentation-id', null, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDeviceConfiguration(): void
    {
        $data = ['test-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                PresentationApiInterface::API_URL_DEVICE_CONFIG,
                [PresentationApiInterface::KEY_PRESENTATION_ID => 'test-presentation-id', PresentationApiInterface::KEY_MANUFACTURER_NAME => 'test-manufacturer-name'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $model = self::createStub(DeviceConfigurationInterface::class);

        $transformer = self::createMock(DeviceConfigurationTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), $transformer, self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));
        $actual = $api->getDeviceConfiguration('test-presentation-id', 'test-manufacturer-name');

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDeviceConfigurationCaches(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-data']);

        $transformer = self::createMock(DeviceConfigurationTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')->willReturn(self::createStub(DeviceConfigurationInterface::class));

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), $transformer, self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        // Second call for the same key is served from the cache without hitting the API.
        $api->getDeviceConfiguration('test-presentation-id');
        $api->getDeviceConfiguration('test-presentation-id');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDeviceConfigurationSkipsCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-data']);

        $transformer = self::createMock(DeviceConfigurationTransformerInterface::class);
        $transformer->expects(self::exactly(2))->method('transform')->willReturn(self::createStub(DeviceConfigurationInterface::class));

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), $transformer, self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        // First call populates the cache; the second bypasses it and hits the API again.
        $api->getDeviceConfiguration('test-presentation-id');
        $api->getDeviceConfiguration('test-presentation-id', skipCache: true);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetDeviceConfigurationUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PresentationApiInterface::UNEXPECTED_RESPONSE);
        $api->getDeviceConfiguration('test-presentation-id', skipCache: $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDeviceConfigurationWithoutOptionalParameters(): void
    {
        $data = ['test-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                PresentationApiInterface::API_URL_DEVICE_CONFIG,
                [PresentationApiInterface::KEY_PRESENTATION_ID => 'test-presentation-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $model = self::createStub(DeviceConfigurationInterface::class);

        $transformer = self::createMock(DeviceConfigurationTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), $transformer, self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));
        $actual = $api->getDeviceConfiguration('test-presentation-id');

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDevicePresentation(): void
    {
        $data = ['test-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                PresentationApiInterface::API_URL,
                [PresentationApiInterface::KEY_PRESENTATION_ID => 'test-presentation-id', PresentationApiInterface::KEY_MANUFACTURER_NAME => 'test-manufacturer-name', PresentationApiInterface::KEY_DEVICE_ID => 'test-device-id', PresentationApiInterface::KEY_VIEW => 'test-view'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                    ApiInterface::HEADER_KEY_IF_NONE_MATCH => 'test-if-none-match',
                    ApiInterface::HEADER_KEY_ACCEPT_LANGUAGE => 'test-accept-language',
                ]
            )
            ->willReturn($data);

        $model = self::createStub(DevicePresentationInterface::class);

        $transformer = self::createMock(DevicePresentationTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), $transformer, self::createStub(CreateDeviceConfigRequestTransformerInterface::class));
        $actual = $api->getDevicePresentation('test-presentation-id', 'test-manufacturer-name', 'test-device-id', 'test-view', 'test-if-none-match', 'test-accept-language');

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDevicePresentationCaches(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-data']);

        $transformer = self::createMock(DevicePresentationTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')->willReturn(self::createStub(DevicePresentationInterface::class));

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), $transformer, self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        // Second call for the same key is served from the cache without hitting the API.
        $api->getDevicePresentation('test-presentation-id');
        $api->getDevicePresentation('test-presentation-id');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDevicePresentationSkipsCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-data']);

        $transformer = self::createMock(DevicePresentationTransformerInterface::class);
        $transformer->expects(self::exactly(2))->method('transform')->willReturn(self::createStub(DevicePresentationInterface::class));

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), $transformer, self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        // First call populates the cache; the second bypasses it and hits the API again.
        $api->getDevicePresentation('test-presentation-id');
        $api->getDevicePresentation('test-presentation-id', skipCache: true);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetDevicePresentationUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PresentationApiInterface::UNEXPECTED_RESPONSE);
        $api->getDevicePresentation('test-presentation-id', skipCache: $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDevicePresentationWithoutOptionalParameters(): void
    {
        $data = ['test-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                PresentationApiInterface::API_URL,
                [PresentationApiInterface::KEY_PRESENTATION_ID => 'test-presentation-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $model = self::createStub(DevicePresentationInterface::class);

        $transformer = self::createMock(DevicePresentationTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new PresentationApi($requestSender, self::createStub(PresentationTransformerInterface::class), new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), $transformer, self::createStub(CreateDeviceConfigRequestTransformerInterface::class));
        $actual = $api->getDevicePresentation('test-presentation-id');

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOne(): void
    {
        $data = ['test-presentation-data'];

        // With a manufacturerName the query carries both filters.
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                PresentationApiInterface::API_URL,
                [
                    PresentationApiInterface::KEY_PRESENTATION_ID => 'test-presentation-id',
                    PresentationApiInterface::KEY_MANUFACTURER_NAME => 'test-manufacturer',
                ],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $presentation = self::createStub(PresentationInterface::class);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));
        $actual = $presentationApi->getOne('test-presentation-id', 'test-manufacturer');

        self::assertSame($presentation, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneCaches(): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(PresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        // Second call for the same key is served from the cache without hitting the API.
        self::assertSame($presentation, $presentationApi->getOne('test-presentation-id', 'test-manufacturer'));
        self::assertSame($presentation, $presentationApi->getOne('test-presentation-id', 'test-manufacturer'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneSkipsCache(): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(PresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($presentation, $presentationApi->getOne('test-presentation-id', 'test-manufacturer'));
        self::assertSame($presentation, $presentationApi->getOne('test-presentation-id', 'test-manufacturer', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetOneUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn([]);

        $presentationTransformer = self::createStub(PresentationTransformerInterface::class);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'), self::createStub(DeviceConfigurationRequestSerializerInterface::class), self::createStub(DeviceConfigurationTransformerInterface::class), self::createStub(DevicePresentationTransformerInterface::class), self::createStub(CreateDeviceConfigRequestTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PresentationApiInterface::UNEXPECTED_RESPONSE);
        $presentationApi->getOne('test-presentation-id', null, $skipCache);
    }
}
