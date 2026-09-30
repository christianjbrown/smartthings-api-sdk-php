<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\DeviceProfileApi;
use ChristianBrown\SmartThings\Api\DeviceProfileApiInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Model\DeviceProfileInterface;
use ChristianBrown\SmartThings\Serializer\CreateDeviceProfileRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceProfileRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfilesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfileTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocaleReferencesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocalizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DeviceProfileApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
final class DeviceProfileApiQueryParametersTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSendsProfileIds(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [DeviceProfileApiInterface::API_URL, [], $this->headers(), [DeviceProfileApiInterface::KEY_ITEMS => ['plain']]],
                [DeviceProfileApiInterface::API_URL.'?profileId=one&profileId=two', [], $this->headers(), [DeviceProfileApiInterface::KEY_ITEMS => ['variant']]],
            ]);
        $plain = [self::createStub(DeviceProfileInterface::class)];
        $variant = [self::createStub(DeviceProfileInterface::class)];
        $transformer = self::createStub(DeviceProfilesTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $api = $this->api($requestSender, deviceProfilesTransformer: $transformer);

        self::assertSame($plain, $api->getMultiple());
        self::assertSame($variant, $api->getMultiple(false, ['one', 'two']));
        self::assertSame($plain, $api->getMultiple());
        self::assertSame($variant, $api->getMultiple(false, ['one', 'two']));
    }

    private function api(JsonApiRequestSenderInterface $requestSender, ?DeviceProfileTransformerInterface $deviceProfileTransformer = null, ?DeviceProfilesTransformerInterface $deviceProfilesTransformer = null, ?LocaleReferencesTransformerInterface $localeReferencesTransformer = null, ?LocalizationTransformerInterface $localizationTransformer = null, ?CreateDeviceProfileRequestSerializerInterface $createDeviceProfileRequestSerializer = null, ?UpdateDeviceProfileRequestSerializerInterface $updateDeviceProfileRequestSerializer = null): DeviceProfileApi
    {
        return new DeviceProfileApi($requestSender, $deviceProfileTransformer ?? self::createStub(DeviceProfileTransformerInterface::class), $deviceProfilesTransformer ?? self::createStub(DeviceProfilesTransformerInterface::class), $localeReferencesTransformer ?? self::createStub(LocaleReferencesTransformerInterface::class), $localizationTransformer ?? self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), $createDeviceProfileRequestSerializer ?? self::createStub(CreateDeviceProfileRequestSerializerInterface::class), $updateDeviceProfileRequestSerializer ?? self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
