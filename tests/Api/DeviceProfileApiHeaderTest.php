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
use ChristianBrown\SmartThings\Model\CreateDeviceProfileRequestInterface;
use ChristianBrown\SmartThings\Model\DeviceProfileInterface;
use ChristianBrown\SmartThings\Model\UpdateDeviceProfileRequestInterface;
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
final class DeviceProfileApiHeaderTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateDeviceProfileSendsOrganization(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(DeviceProfileApiInterface::API_URL, [], $this->headers() + [ApiInterface::HEADER_KEY_ORGANIZATION => 'test-org'], ['test-body'])
            ->willReturn(['test-data']);
        $serializer = self::createStub(CreateDeviceProfileRequestSerializerInterface::class);
        $serializer->method('serialize')->willReturn(['test-body']);
        $result = self::createStub(DeviceProfileInterface::class);
        $transformer = self::createStub(DeviceProfileTransformerInterface::class);
        $transformer->method('transform')->willReturn($result);
        $api = $this->api($requestSender, createDeviceProfileRequestSerializer: $serializer, deviceProfileTransformer: $transformer);

        self::assertSame($result, $api->createDeviceProfile(self::createStub(CreateDeviceProfileRequestInterface::class), 'test-org'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteDeviceProfileSendsOrganization(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(sprintf(DeviceProfileApiInterface::API_URL_SPRINTF, 'test-profile'), [], $this->headers() + [ApiInterface::HEADER_KEY_ORGANIZATION => 'test-org'])
            ->willReturn([]);
        $api = $this->api($requestSender);

        $api->deleteDeviceProfile('test-profile', 'test-org');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSendsOrganizationAndCachesPerVariant(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [DeviceProfileApiInterface::API_URL, [], $this->headers(), [DeviceProfileApiInterface::KEY_ITEMS => ['plain']]],
                [DeviceProfileApiInterface::API_URL, [], $this->headers() + [ApiInterface::HEADER_KEY_ORGANIZATION => 'test-org'], [DeviceProfileApiInterface::KEY_ITEMS => ['variant']]],
            ]);
        $plain = [self::createStub(DeviceProfileInterface::class)];
        $variant = [self::createStub(DeviceProfileInterface::class)];
        $transformer = self::createStub(DeviceProfilesTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $api = $this->api($requestSender, deviceProfilesTransformer: $transformer);

        self::assertSame($plain, $api->getMultiple());
        self::assertSame($variant, $api->getMultiple(false, null, 'test-org'));
        self::assertSame($plain, $api->getMultiple());
        self::assertSame($variant, $api->getMultiple(false, null, 'test-org'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSendsOrganizationAndLanguageAndCachesPerVariant(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [sprintf(DeviceProfileApiInterface::API_URL_SPRINTF, 'test-profile'), [], $this->headers(), ['plain']],
                [sprintf(DeviceProfileApiInterface::API_URL_SPRINTF, 'test-profile'), [], $this->headers() + [ApiInterface::HEADER_KEY_ORGANIZATION => 'test-org', ApiInterface::HEADER_KEY_ACCEPT_LANGUAGE => 'fr-FR'], ['variant']],
            ]);
        $plain = self::createStub(DeviceProfileInterface::class);
        $variant = self::createStub(DeviceProfileInterface::class);
        $transformer = self::createStub(DeviceProfileTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $api = $this->api($requestSender, deviceProfileTransformer: $transformer);

        self::assertSame($plain, $api->getOneById('test-profile'));
        self::assertSame($variant, $api->getOneById('test-profile', false, 'test-org', 'fr-FR'));
        self::assertSame($plain, $api->getOneById('test-profile'));
        self::assertSame($variant, $api->getOneById('test-profile', false, 'test-org', 'fr-FR'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateDeviceProfileSendsOrganization(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(sprintf(DeviceProfileApiInterface::API_URL_SPRINTF, 'test-profile'), [], $this->headers() + [ApiInterface::HEADER_KEY_ORGANIZATION => 'test-org'], ['test-body'])
            ->willReturn(['test-data']);
        $serializer = self::createStub(UpdateDeviceProfileRequestSerializerInterface::class);
        $serializer->method('serialize')->willReturn(['test-body']);
        $result = self::createStub(DeviceProfileInterface::class);
        $transformer = self::createStub(DeviceProfileTransformerInterface::class);
        $transformer->method('transform')->willReturn($result);
        $api = $this->api($requestSender, updateDeviceProfileRequestSerializer: $serializer, deviceProfileTransformer: $transformer);

        self::assertSame($result, $api->updateDeviceProfile('test-profile', self::createStub(UpdateDeviceProfileRequestInterface::class), 'test-org'));
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
