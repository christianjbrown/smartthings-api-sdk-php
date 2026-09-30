<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\DevicePreferenceDefinitionApi;
use ChristianBrown\SmartThings\Api\DevicePreferenceDefinitionApiInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Model\DevicePreferenceDefinitionInterface;
use ChristianBrown\SmartThings\Model\PreferenceRequestInterface;
use ChristianBrown\SmartThings\Serializer\PreferenceLocalizationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PreferenceRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocaleReferencesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocalizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DevicePreferenceDefinitionApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
final class DevicePreferenceDefinitionApiHeaderTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreatePreferenceSendsOrganization(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(DevicePreferenceDefinitionApiInterface::API_URL, [], $this->headers() + [ApiInterface::HEADER_KEY_ORGANIZATION => 'test-org'], ['test-body'])
            ->willReturn(['test-data']);
        $serializer = self::createStub(PreferenceRequestSerializerInterface::class);
        $serializer->method('serialize')->willReturn(['test-body']);
        $result = self::createStub(DevicePreferenceDefinitionInterface::class);
        $transformer = self::createStub(DevicePreferenceDefinitionTransformerInterface::class);
        $transformer->method('transform')->willReturn($result);
        $api = $this->api($requestSender, preferenceRequestSerializer: $serializer, devicePreferenceDefinitionTransformer: $transformer);

        self::assertSame($result, $api->createPreference(self::createStub(PreferenceRequestInterface::class), 'test-org'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeletePreferenceSendsOrganization(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(sprintf(DevicePreferenceDefinitionApiInterface::API_URL_SPRINTF, 'test-pref'), [], $this->headers() + [ApiInterface::HEADER_KEY_ORGANIZATION => 'test-org'])
            ->willReturn([]);
        $api = $this->api($requestSender);

        $api->deletePreferenceById('test-pref', 'test-org');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdatePreferenceSendsOrganization(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(sprintf(DevicePreferenceDefinitionApiInterface::API_URL_SPRINTF, 'test-pref'), [], $this->headers() + [ApiInterface::HEADER_KEY_ORGANIZATION => 'test-org'], ['test-body'])
            ->willReturn(['test-data']);
        $serializer = self::createStub(PreferenceRequestSerializerInterface::class);
        $serializer->method('serialize')->willReturn(['test-body']);
        $result = self::createStub(DevicePreferenceDefinitionInterface::class);
        $transformer = self::createStub(DevicePreferenceDefinitionTransformerInterface::class);
        $transformer->method('transform')->willReturn($result);
        $api = $this->api($requestSender, preferenceRequestSerializer: $serializer, devicePreferenceDefinitionTransformer: $transformer);

        self::assertSame($result, $api->updatePreferenceById('test-pref', self::createStub(PreferenceRequestInterface::class), 'test-org'));
    }

    private function api(JsonApiRequestSenderInterface $requestSender, ?DevicePreferenceDefinitionTransformerInterface $devicePreferenceDefinitionTransformer = null, ?DevicePreferenceDefinitionsTransformerInterface $devicePreferenceDefinitionsTransformer = null, ?LocaleReferencesTransformerInterface $localeReferencesTransformer = null, ?LocalizationTransformerInterface $localizationTransformer = null, ?PreferenceRequestSerializerInterface $preferenceRequestSerializer = null, ?PreferenceLocalizationRequestSerializerInterface $preferenceLocalizationRequestSerializer = null): DevicePreferenceDefinitionApi
    {
        return new DevicePreferenceDefinitionApi($requestSender, $devicePreferenceDefinitionTransformer ?? self::createStub(DevicePreferenceDefinitionTransformerInterface::class), $devicePreferenceDefinitionsTransformer ?? self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), $localeReferencesTransformer ?? self::createStub(LocaleReferencesTransformerInterface::class), $localizationTransformer ?? self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), $preferenceRequestSerializer ?? self::createStub(PreferenceRequestSerializerInterface::class), $preferenceLocalizationRequestSerializer ?? self::createStub(PreferenceLocalizationRequestSerializerInterface::class), new RequestUrlBuilder());
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
