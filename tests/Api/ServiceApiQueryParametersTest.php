<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\ServiceApi;
use ChristianBrown\SmartThings\Api\ServiceApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataInterface;
use ChristianBrown\SmartThings\Serializer\ServiceSubscriptionRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityNamesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceSubscriptionReceiptTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ServiceApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
final class ServiceApiQueryParametersTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetAvailableCapabilitiesSendsPostalCodeAndCachesPerVariant(): void
    {
        $plainUrl = sprintf(ServiceApiInterface::API_URL_CAPABILITIES_SPRINTF, 'test-location-id');
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [$plainUrl, [], $this->headers(), ['plain']],
                [$plainUrl.'?postalCode=SW1A', [], $this->headers(), ['variant']],
            ]);
        $transformer = self::createStub(ServiceCapabilityNamesTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], ['plain-name']], [['variant'], ['variant-name']]]);
        $api = $this->api($requestSender, serviceCapabilityNamesTransformer: $transformer);

        self::assertSame(['plain-name'], $api->getAvailableCapabilities('test-location-id'));
        self::assertSame(['variant-name'], $api->getAvailableCapabilities('test-location-id', false, 'SW1A'));
        self::assertSame(['plain-name'], $api->getAvailableCapabilities('test-location-id'));
        self::assertSame(['variant-name'], $api->getAvailableCapabilities('test-location-id', false, 'SW1A'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCapabilitySendsPostalCode(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(sprintf(ServiceApiInterface::API_URL_CAPABILITIES_SPRINTF, 'test-location-id').'?name=weather&postalCode=SW1A', [], $this->headers())
            ->willReturn(['test-data']);
        $data = self::createStub(ServiceCapabilityDataInterface::class);
        $transformer = self::createStub(ServiceCapabilityDataTransformerInterface::class);
        $transformer->method('transform')->willReturn($data);

        self::assertSame($data, $this->api($requestSender, serviceCapabilityDataTransformer: $transformer)->getCapability('test-location-id', 'weather', false, 'SW1A'));
    }

    private function api(JsonApiRequestSenderInterface $requestSender, ?ServiceLocationInfoTransformerInterface $serviceLocationInfoTransformer = null, ?ServiceCapabilityNamesTransformerInterface $serviceCapabilityNamesTransformer = null, ?ServiceCapabilityDataTransformerInterface $serviceCapabilityDataTransformer = null, ?ServiceSubscriptionRequestSerializerInterface $serviceSubscriptionRequestSerializer = null, ?ServiceSubscriptionReceiptTransformerInterface $serviceSubscriptionReceiptTransformer = null): ServiceApi
    {
        return new ServiceApi($requestSender, $serviceLocationInfoTransformer ?? self::createStub(ServiceLocationInfoTransformerInterface::class), $serviceCapabilityNamesTransformer ?? self::createStub(ServiceCapabilityNamesTransformerInterface::class), $serviceCapabilityDataTransformer ?? self::createStub(ServiceCapabilityDataTransformerInterface::class), new Token('test-api-token'), $serviceSubscriptionRequestSerializer ?? self::createStub(ServiceSubscriptionRequestSerializerInterface::class), $serviceSubscriptionReceiptTransformer ?? self::createStub(ServiceSubscriptionReceiptTransformerInterface::class), new RequestUrlBuilder(), self::createStub(JsonApiRequestSenderInterface::class));
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
