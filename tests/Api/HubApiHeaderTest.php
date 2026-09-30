<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\HubApi;
use ChristianBrown\SmartThings\Api\HubApiInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Model\HubEnrolledChannelInterface;
use ChristianBrown\SmartThings\Model\HubInstalledDriverInterface;
use ChristianBrown\SmartThings\Serializer\HubDeviceUpdateRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\HubDriverInstallRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\HubCharacteristicsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubEnrolledChannelsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriversTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubInstalledDriverTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(HubApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
final class HubApiHeaderTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetEnrolledChannelsSendsLanguageAndCachesPerVariant(): void
    {
        $url = sprintf(HubApiInterface::API_URL_CHANNELS_SPRINTF, 'test-hub');
        $query = [HubApiInterface::KEY_CHANNEL_TYPE => HubApiInterface::CHANNEL_TYPE_DRIVERS];
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [$url, $query, $this->headers(), ['plain']],
                [$url, $query, $this->headers() + [ApiInterface::HEADER_KEY_ACCEPT_LANGUAGE => 'fr-FR'], ['variant']],
            ]);
        $plain = [self::createStub(HubEnrolledChannelInterface::class)];
        $variant = [self::createStub(HubEnrolledChannelInterface::class)];
        $transformer = self::createStub(HubEnrolledChannelsTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $api = $this->api($requestSender, hubEnrolledChannelsTransformer: $transformer);

        self::assertSame($plain, $api->getEnrolledChannels('test-hub'));
        self::assertSame($variant, $api->getEnrolledChannels('test-hub', false, 'fr-FR'));
        self::assertSame($plain, $api->getEnrolledChannels('test-hub'));
        self::assertSame($variant, $api->getEnrolledChannels('test-hub', false, 'fr-FR'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstalledDriversSendsLanguageAndCachesPerVariant(): void
    {
        $url = sprintf(HubApiInterface::API_URL_DRIVERS_SPRINTF, 'test-hub');
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [$url, [], $this->headers(), ['plain']],
                [$url, [], $this->headers() + [ApiInterface::HEADER_KEY_ACCEPT_LANGUAGE => 'fr-FR'], ['variant']],
            ]);
        $plain = [self::createStub(HubInstalledDriverInterface::class)];
        $variant = [self::createStub(HubInstalledDriverInterface::class)];
        $transformer = self::createStub(HubInstalledDriversTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $api = $this->api($requestSender, hubInstalledDriversTransformer: $transformer);

        self::assertSame($plain, $api->getInstalledDrivers('test-hub'));
        self::assertSame($variant, $api->getInstalledDrivers('test-hub', null, false, 'fr-FR'));
        self::assertSame($plain, $api->getInstalledDrivers('test-hub'));
        self::assertSame($variant, $api->getInstalledDrivers('test-hub', null, false, 'fr-FR'));
    }

    private function api(JsonApiRequestSenderInterface $requestSender, ?HubTransformerInterface $hubTransformer = null, ?HubCharacteristicsTransformerInterface $hubCharacteristicsTransformer = null, ?HubInstalledDriverTransformerInterface $hubInstalledDriverTransformer = null, ?HubInstalledDriversTransformerInterface $hubInstalledDriversTransformer = null, ?HubEnrolledChannelsTransformerInterface $hubEnrolledChannelsTransformer = null, ?HubDriverInstallRequestSerializerInterface $hubDriverInstallRequestSerializer = null, ?HubDeviceUpdateRequestSerializerInterface $hubDeviceUpdateRequestSerializer = null): HubApi
    {
        return new HubApi($requestSender, $hubTransformer ?? self::createStub(HubTransformerInterface::class), $hubCharacteristicsTransformer ?? self::createStub(HubCharacteristicsTransformerInterface::class), $hubInstalledDriverTransformer ?? self::createStub(HubInstalledDriverTransformerInterface::class), $hubInstalledDriversTransformer ?? self::createStub(HubInstalledDriversTransformerInterface::class), $hubEnrolledChannelsTransformer ?? self::createStub(HubEnrolledChannelsTransformerInterface::class), new Token('test-api-token'), $hubDriverInstallRequestSerializer ?? self::createStub(HubDriverInstallRequestSerializerInterface::class), $hubDeviceUpdateRequestSerializer ?? self::createStub(HubDeviceUpdateRequestSerializerInterface::class));
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
