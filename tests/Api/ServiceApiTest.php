<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\ServiceApi;
use ChristianBrown\SmartThings\Api\ServiceApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataInterface;
use ChristianBrown\SmartThings\Model\ServiceLocationInfoInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityNamesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ServiceApi::class)]
#[CoversClass(Token::class)]
final class ServiceApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetAvailableCapabilities(): void
    {
        $data = ['name' => ['weather']];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(ServiceApiInterface::API_URL_CAPABILITIES_SPRINTF, 'test-location-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $names = ['weather', 'airQuality'];

        $namesTransformer = self::createMock(ServiceCapabilityNamesTransformerInterface::class);
        $namesTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($names);

        $api = self::createApi($requestSender, namesTransformer: $namesTransformer);

        self::assertSame($names, $api->getAvailableCapabilities('test-location-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetAvailableCapabilitiesCaches(): void
    {
        $names = ['weather'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['name' => ['weather']]);

        $namesTransformer = self::createMock(ServiceCapabilityNamesTransformerInterface::class);
        $namesTransformer->expects(self::once())->method('transform')->willReturn($names);

        $api = self::createApi($requestSender, namesTransformer: $namesTransformer);

        // Second call is served from the cache without hitting the API.
        self::assertSame($names, $api->getAvailableCapabilities('test-location-id'));
        self::assertSame($names, $api->getAvailableCapabilities('test-location-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetAvailableCapabilitiesSkipsCache(): void
    {
        $names = ['weather'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['name' => ['weather']]);

        $namesTransformer = self::createMock(ServiceCapabilityNamesTransformerInterface::class);
        $namesTransformer->expects(self::exactly(2))->method('transform')->willReturn($names);

        $api = self::createApi($requestSender, namesTransformer: $namesTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($names, $api->getAvailableCapabilities('test-location-id'));
        self::assertSame($names, $api->getAvailableCapabilities('test-location-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetAvailableCapabilitiesUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = self::createApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ServiceApiInterface::UNEXPECTED_RESPONSE);
        $api->getAvailableCapabilities('test-location-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCapability(): void
    {
        $data = ['test-capability-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(ServiceApiInterface::API_URL_CAPABILITIES_SPRINTF, 'test-location-id'),
                [ServiceApiInterface::KEY_NAME => 'weather,airQuality'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capabilityData = self::createStub(ServiceCapabilityDataInterface::class);

        $dataTransformer = self::createMock(ServiceCapabilityDataTransformerInterface::class);
        $dataTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($capabilityData);

        $api = self::createApi($requestSender, dataTransformer: $dataTransformer);

        // A single call accepts one name or several joined with commas.
        self::assertSame($capabilityData, $api->getCapability('test-location-id', 'weather,airQuality'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCapabilityCaches(): void
    {
        $capabilityData = self::createStub(ServiceCapabilityDataInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-capability-data']);

        $dataTransformer = self::createMock(ServiceCapabilityDataTransformerInterface::class);
        $dataTransformer->expects(self::once())->method('transform')->willReturn($capabilityData);

        $api = self::createApi($requestSender, dataTransformer: $dataTransformer);

        // Second call for the same location and name is served from the cache without hitting the API.
        self::assertSame($capabilityData, $api->getCapability('test-location-id', 'weather'));
        self::assertSame($capabilityData, $api->getCapability('test-location-id', 'weather'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCapabilitySkipsCache(): void
    {
        $capabilityData = self::createStub(ServiceCapabilityDataInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-capability-data']);

        $dataTransformer = self::createMock(ServiceCapabilityDataTransformerInterface::class);
        $dataTransformer->expects(self::exactly(2))->method('transform')->willReturn($capabilityData);

        $api = self::createApi($requestSender, dataTransformer: $dataTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($capabilityData, $api->getCapability('test-location-id', 'weather'));
        self::assertSame($capabilityData, $api->getCapability('test-location-id', 'weather', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetCapabilityUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = self::createApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ServiceApiInterface::UNEXPECTED_RESPONSE);
        $api->getCapability('test-location-id', 'weather', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetLocationInfo(): void
    {
        $data = ['test-location-info'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(ServiceApiInterface::API_URL_INFO_SPRINTF, 'test-location-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $info = self::createStub(ServiceLocationInfoInterface::class);

        $infoTransformer = self::createMock(ServiceLocationInfoTransformerInterface::class);
        $infoTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($info);

        $api = self::createApi($requestSender, locationInfoTransformer: $infoTransformer);

        self::assertSame($info, $api->getLocationInfo('test-location-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetLocationInfoCaches(): void
    {
        $info = self::createStub(ServiceLocationInfoInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-location-info']);

        $infoTransformer = self::createMock(ServiceLocationInfoTransformerInterface::class);
        $infoTransformer->expects(self::once())->method('transform')->willReturn($info);

        $api = self::createApi($requestSender, locationInfoTransformer: $infoTransformer);

        // Second call is served from the cache without hitting the API.
        self::assertSame($info, $api->getLocationInfo('test-location-id'));
        self::assertSame($info, $api->getLocationInfo('test-location-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetLocationInfoSkipsCache(): void
    {
        $info = self::createStub(ServiceLocationInfoInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-location-info']);

        $infoTransformer = self::createMock(ServiceLocationInfoTransformerInterface::class);
        $infoTransformer->expects(self::exactly(2))->method('transform')->willReturn($info);

        $api = self::createApi($requestSender, locationInfoTransformer: $infoTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($info, $api->getLocationInfo('test-location-id'));
        self::assertSame($info, $api->getLocationInfo('test-location-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetLocationInfoUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = self::createApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ServiceApiInterface::UNEXPECTED_RESPONSE);
        $api->getLocationInfo('test-location-id', $skipCache);
    }

    /**
     * @throws Exception
     */
    private static function createApi(
        JsonApiRequestSenderInterface $requestSender,
        ?ServiceLocationInfoTransformerInterface $locationInfoTransformer = null,
        ?ServiceCapabilityNamesTransformerInterface $namesTransformer = null,
        ?ServiceCapabilityDataTransformerInterface $dataTransformer = null,
    ): ServiceApi {
        return new ServiceApi(
            $requestSender,
            $locationInfoTransformer ?? self::createStub(ServiceLocationInfoTransformerInterface::class),
            $namesTransformer ?? self::createStub(ServiceCapabilityNamesTransformerInterface::class),
            $dataTransformer ?? self::createStub(ServiceCapabilityDataTransformerInterface::class),
            new Token('test-api-token'),
        );
    }
}
