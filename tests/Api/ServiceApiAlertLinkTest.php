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
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Serializer\ServiceSubscriptionRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityNamesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceLocationInfoTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceSubscriptionReceiptTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ServiceApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
final class ServiceApiAlertLinkTest extends TestCase
{
    /**
     * @param array<array-key, mixed> $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[DataProvider('provideGetAlertLinkRejectsAResponseWithoutAnAddressCases')]
    public function testGetAlertLinkRejectsAResponseWithoutAnAddress(array $data): void
    {
        $sender = self::createStub(JsonApiRequestSenderInterface::class);
        $sender->method('get')->willReturn($data);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ServiceApiInterface::UNEXPECTED_LOCATION);

        $this->api(self::createStub(JsonApiRequestSenderInterface::class), $sender)->getAlertLink('test-location');
    }

    /**
     * @return iterable<string, array{array<array-key, mixed>}>
     */
    public static function provideGetAlertLinkRejectsAResponseWithoutAnAddressCases(): iterable
    {
        yield 'empty' => [[]];
        yield 'not a string' => [[ServiceApiInterface::KEY_LOCATION => ['nested']]];
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetAlertLinkSendsQueryAndHeaders(): void
    {
        $sender = self::createMock(JsonApiRequestSenderInterface::class);
        $sender->expects(self::once())->method('get')
            ->with(
                sprintf(ServiceApiInterface::API_URL_ALERT_LINK_SPRINTF, 'test-location').'?postalCode=SW1A&subscriptionId=test-sub',
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                    ServiceApiInterface::HEADER_KEY_UNITS => 'm',
                    ApiInterface::HEADER_KEY_ACCEPT_LANGUAGE => 'fr-FR',
                ]
            )
            ->willReturn([ServiceApiInterface::KEY_LOCATION => 'https://weather.example/alert']);

        self::assertSame('https://weather.example/alert', $this->api(self::createStub(JsonApiRequestSenderInterface::class), $sender)->getAlertLink('test-location', 'SW1A', 'test-sub', 'm', 'fr-FR'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetAlertLinkWithoutOptionsSendsOnlyTheAuthorization(): void
    {
        $sender = self::createMock(JsonApiRequestSenderInterface::class);
        $sender->expects(self::once())->method('get')
            ->with(
                sprintf(ServiceApiInterface::API_URL_ALERT_LINK_SPRINTF, 'test-location'),
                [],
                [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')]
            )
            ->willReturn([ServiceApiInterface::KEY_LOCATION => 'https://weather.example/alert']);

        self::assertSame('https://weather.example/alert', $this->api(self::createStub(JsonApiRequestSenderInterface::class), $sender)->getAlertLink('test-location'));
    }

    private function api(JsonApiRequestSenderInterface $requestSender, JsonApiRequestSenderInterface $alertLinkRequestSender): ServiceApi
    {
        return new ServiceApi($requestSender, self::createStub(ServiceLocationInfoTransformerInterface::class), self::createStub(ServiceCapabilityNamesTransformerInterface::class), self::createStub(ServiceCapabilityDataTransformerInterface::class), new Token('test-api-token'), self::createStub(ServiceSubscriptionRequestSerializerInterface::class), self::createStub(ServiceSubscriptionReceiptTransformerInterface::class), new RequestUrlBuilder(), $alertLinkRequestSender);
    }
}
