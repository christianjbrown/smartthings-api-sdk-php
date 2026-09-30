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
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CreateDeviceProfileRequest;
use ChristianBrown\SmartThings\Model\DeviceProfileInterface;
use ChristianBrown\SmartThings\Model\LocaleReferenceInterface;
use ChristianBrown\SmartThings\Model\LocalizationInterface;
use ChristianBrown\SmartThings\Model\UpdateDeviceProfileRequest;
use ChristianBrown\SmartThings\Serializer\CreateDeviceProfileRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CreateDeviceProfileRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceProfileRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceProfileRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfilesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceProfileTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocaleReferencesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocalizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(CreateDeviceProfileRequest::class)]
#[CoversClass(CreateDeviceProfileRequestSerializer::class)]
#[CoversClass(DeviceProfileApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
#[CoversClass(UpdateDeviceProfileRequest::class)]
#[CoversClass(UpdateDeviceProfileRequestSerializer::class)]
final class DeviceProfileApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateDeviceProfile(): void
    {
        $data = ['test-profile-data'];

        $request = new CreateDeviceProfileRequest('thermostat1.model1', [['id' => 'main']]);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                DeviceProfileApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $createDeviceProfileRequestSerializer = self::createMock(CreateDeviceProfileRequestSerializerInterface::class);
        $createDeviceProfileRequestSerializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $profile = self::createStub(DeviceProfileInterface::class);

        $deviceProfileTransformer = self::createMock(DeviceProfileTransformerInterface::class);
        $deviceProfileTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($profile);

        $localeReferencesTransformer = self::createStub(LocaleReferencesTransformerInterface::class);
        $devicesProfilesTransformer = self::createStub(DeviceProfilesTransformerInterface::class);

        $api = new DeviceProfileApi($requestSender, $deviceProfileTransformer, $devicesProfilesTransformer, $localeReferencesTransformer, self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), $createDeviceProfileRequestSerializer, self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());
        $actual = $api->createDeviceProfile($request);

        self::assertSame($profile, $actual);
    }

    /**
     * createDeviceProfile() invalidates the cached profile list, so a subsequent
     * getMultiple() call hits the API again instead of returning a stale list.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateDeviceProfileInvalidatesListCache(): void
    {
        $profile = self::createStub(DeviceProfileInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn([DeviceProfileApiInterface::KEY_ITEMS => ['test-item']]);
        $requestSender->expects(self::once())->method('post')
            ->willReturn(['test-profile-data']);

        $deviceProfileTransformer = self::createStub(DeviceProfileTransformerInterface::class);
        $deviceProfileTransformer->method('transform')
            ->willReturn($profile);

        $devicesProfilesTransformer = self::createStub(DeviceProfilesTransformerInterface::class);
        $devicesProfilesTransformer->method('transform')
            ->willReturn([$profile]);

        $api = new DeviceProfileApi($requestSender, $deviceProfileTransformer, $devicesProfilesTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        $api->getMultiple();
        $api->createDeviceProfile(new CreateDeviceProfileRequest('thermostat1.model1', [['id' => 'main']]));
        $api->getMultiple();
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateDeviceProfileUnexpectedResponse(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $api = new DeviceProfileApi($requestSender, self::createStub(DeviceProfileTransformerInterface::class), self::createStub(DeviceProfilesTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DeviceProfileApiInterface::UNEXPECTED_RESPONSE);
        $api->createDeviceProfile(new CreateDeviceProfileRequest('thermostat1.model1', [['id' => 'main']]));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteDeviceProfile(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(
                sprintf(DeviceProfileApiInterface::API_URL_SPRINTF, 'test-profile-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $api = new DeviceProfileApi($requestSender, self::createStub(DeviceProfileTransformerInterface::class), self::createStub(DeviceProfilesTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());
        $api->deleteDeviceProfile('test-profile-id');

        $this->addToAssertionCount(1);
    }

    /**
     * deleteDeviceProfile() invalidates the cached copy of this profile and the
     * cached profile list, so subsequent lookups hit the API again.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteDeviceProfileInvalidatesCaches(): void
    {
        $profile = self::createStub(DeviceProfileInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn(['test-profile-data']);
        $requestSender->expects(self::once())->method('delete')
            ->willReturn([]);

        $deviceProfileTransformer = self::createStub(DeviceProfileTransformerInterface::class);
        $deviceProfileTransformer->method('transform')
            ->willReturn($profile);

        $api = new DeviceProfileApi($requestSender, $deviceProfileTransformer, self::createStub(DeviceProfilesTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        $api->getOneById('test-profile-id');
        $api->deleteDeviceProfile('test-profile-id');
        $api->getOneById('test-profile-id');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetLocales(): void
    {
        $data = [
            DeviceProfileApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceProfileApiInterface::API_URL_LOCALES_SPRINTF, 'test-device-profile-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $locales = [self::createStub(LocaleReferenceInterface::class)];

        $localeReferencesTransformer = self::createMock(LocaleReferencesTransformerInterface::class);
        $localeReferencesTransformer->expects(self::once())->method('transform')
            ->with($data[DeviceProfileApiInterface::KEY_ITEMS])
            ->willReturn($locales);

        $api = new DeviceProfileApi($requestSender, self::createStub(DeviceProfileTransformerInterface::class), self::createStub(DeviceProfilesTransformerInterface::class), $localeReferencesTransformer, self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        self::assertSame($locales, $api->getLocales('test-device-profile-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetLocalesCaches(): void
    {
        $locales = [self::createStub(LocaleReferenceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([DeviceProfileApiInterface::KEY_ITEMS => ['test-item-1']]);

        $localeReferencesTransformer = self::createMock(LocaleReferencesTransformerInterface::class);
        $localeReferencesTransformer->expects(self::once())->method('transform')->willReturn($locales);

        $api = new DeviceProfileApi($requestSender, self::createStub(DeviceProfileTransformerInterface::class), self::createStub(DeviceProfilesTransformerInterface::class), $localeReferencesTransformer, self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        // Second call for the same id is served from the cache without hitting the API.
        self::assertSame($locales, $api->getLocales('test-device-profile-id'));
        self::assertSame($locales, $api->getLocales('test-device-profile-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetLocalesSkipsCache(): void
    {
        $locales = [self::createStub(LocaleReferenceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn([DeviceProfileApiInterface::KEY_ITEMS => ['test-item-1']]);

        $localeReferencesTransformer = self::createMock(LocaleReferencesTransformerInterface::class);
        $localeReferencesTransformer->expects(self::exactly(2))->method('transform')->willReturn($locales);

        $api = new DeviceProfileApi($requestSender, self::createStub(DeviceProfileTransformerInterface::class), self::createStub(DeviceProfilesTransformerInterface::class), $localeReferencesTransformer, self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($locales, $api->getLocales('test-device-profile-id'));
        self::assertSame($locales, $api->getLocales('test-device-profile-id', true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[DeviceProfileApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[DeviceProfileApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetLocalesUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn($data);

        $api = new DeviceProfileApi($requestSender, self::createStub(DeviceProfileTransformerInterface::class), self::createStub(DeviceProfilesTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceProfileApiInterface::UNEXPECTED_RESPONSE_SPRINTF, DeviceProfileApiInterface::KEY_ITEMS));
        $api->getLocales('test-device-profile-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            DeviceProfileApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DeviceProfileApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $profiles = [self::createStub(DeviceProfileInterface::class), self::createStub(DeviceProfileInterface::class)];

        $profileTransformer = self::createStub(DeviceProfileTransformerInterface::class);

        $profilesTransformer = self::createMock(DeviceProfilesTransformerInterface::class);
        $profilesTransformer->expects(self::once())->method('transform')
            ->with($data[DeviceProfileApiInterface::KEY_ITEMS])
            ->willReturn($profiles);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());
        $actual = $profileApi->getMultiple();

        self::assertSame($profiles, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            DeviceProfileApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $profiles = [self::createStub(DeviceProfileInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $profileTransformer = self::createStub(DeviceProfileTransformerInterface::class);

        $profilesTransformer = self::createMock(DeviceProfilesTransformerInterface::class);
        $profilesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[DeviceProfileApiInterface::KEY_ITEMS])
            ->willReturn($profiles);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        // Second call is served from the cache without hitting the API.
        self::assertSame($profiles, $profileApi->getMultiple());
        self::assertSame($profiles, $profileApi->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            DeviceProfileApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $profiles = [self::createStub(DeviceProfileInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $profileTransformer = self::createStub(DeviceProfileTransformerInterface::class);

        $profilesTransformer = self::createMock(DeviceProfilesTransformerInterface::class);
        $profilesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[DeviceProfileApiInterface::KEY_ITEMS])
            ->willReturn($profiles);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($profiles, $profileApi->getMultiple());
        self::assertSame($profiles, $profileApi->getMultiple(true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[DeviceProfileApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[DeviceProfileApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DeviceProfileApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $profileTransformer = self::createStub(DeviceProfileTransformerInterface::class);
        $profilesTransformer = self::createStub(DeviceProfilesTransformerInterface::class);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceProfileApiInterface::UNEXPECTED_RESPONSE_SPRINTF, DeviceProfileApiInterface::KEY_ITEMS));
        $profileApi->getMultiple($skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-profile-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceProfileApiInterface::API_URL_SPRINTF, 'test-profile-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $profile = self::createStub(DeviceProfileInterface::class);

        $profileTransformer = self::createMock(DeviceProfileTransformerInterface::class);
        $profileTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($profile);

        $profilesTransformer = self::createStub(DeviceProfilesTransformerInterface::class);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());
        $actual = $profileApi->getOneById('test-profile-id');

        self::assertSame($profile, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $data = ['test-profile-data'];

        $profile = self::createStub(DeviceProfileInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                sprintf(DeviceProfileApiInterface::API_URL_SPRINTF, 'test-profile-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $profileTransformer = self::createMock(DeviceProfileTransformerInterface::class);
        $profileTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($profile);

        $profilesTransformer = self::createStub(DeviceProfilesTransformerInterface::class);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        // Second call for the same id is served from the cache without hitting the API.
        self::assertSame($profile, $profileApi->getOneById('test-profile-id'));
        self::assertSame($profile, $profileApi->getOneById('test-profile-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../deviceprofiles'])]
    public function testGetOneByIdEncodesId(string $deviceProfileId): void
    {
        $data = ['test-profile-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceProfileApiInterface::API_URL_SPRINTF, rawurlencode($deviceProfileId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $profile = self::createStub(DeviceProfileInterface::class);

        $profileTransformer = self::createMock(DeviceProfileTransformerInterface::class);
        $profileTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($profile);

        $profilesTransformer = self::createStub(DeviceProfilesTransformerInterface::class);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());
        $actual = $profileApi->getOneById($deviceProfileId);

        self::assertSame($profile, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $data = ['test-profile-data'];

        $profile = self::createStub(DeviceProfileInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->with(
                sprintf(DeviceProfileApiInterface::API_URL_SPRINTF, 'test-profile-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $profileTransformer = self::createMock(DeviceProfileTransformerInterface::class);
        $profileTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($profile);

        $profilesTransformer = self::createStub(DeviceProfilesTransformerInterface::class);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($profile, $profileApi->getOneById('test-profile-id'));
        self::assertSame($profile, $profileApi->getOneById('test-profile-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetOneByIdUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceProfileApiInterface::API_URL_SPRINTF, 'test-profile-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $profileTransformer = self::createStub(DeviceProfileTransformerInterface::class);
        $profilesTransformer = self::createStub(DeviceProfilesTransformerInterface::class);

        $profileApi = new DeviceProfileApi($requestSender, $profileTransformer, $profilesTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DeviceProfileApiInterface::UNEXPECTED_RESPONSE);
        $profileApi->getOneById('test-profile-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetTranslations(): void
    {
        $data = ['test-localization-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DeviceProfileApiInterface::API_URL_TRANSLATIONS_SPRINTF, 'test-device-profile-id', 'ko'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $localization = self::createStub(LocalizationInterface::class);

        $localizationTransformer = self::createMock(LocalizationTransformerInterface::class);
        $localizationTransformer->expects(self::once())->method('transform')->with($data)->willReturn($localization);

        $api = new DeviceProfileApi($requestSender, self::createStub(DeviceProfileTransformerInterface::class), self::createStub(DeviceProfilesTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), $localizationTransformer, new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        self::assertSame($localization, $api->getTranslations('test-device-profile-id', 'ko'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetTranslationsCaches(): void
    {
        $localization = self::createStub(LocalizationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-localization-data']);

        $localizationTransformer = self::createMock(LocalizationTransformerInterface::class);
        $localizationTransformer->expects(self::once())->method('transform')->willReturn($localization);

        $api = new DeviceProfileApi($requestSender, self::createStub(DeviceProfileTransformerInterface::class), self::createStub(DeviceProfilesTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), $localizationTransformer, new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        // Second call for the same id and tag is served from the cache without hitting the API.
        self::assertSame($localization, $api->getTranslations('test-device-profile-id', 'ko'));
        self::assertSame($localization, $api->getTranslations('test-device-profile-id', 'ko'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetTranslationsSkipsCache(): void
    {
        $localization = self::createStub(LocalizationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-localization-data']);

        $localizationTransformer = self::createMock(LocalizationTransformerInterface::class);
        $localizationTransformer->expects(self::exactly(2))->method('transform')->willReturn($localization);

        $api = new DeviceProfileApi($requestSender, self::createStub(DeviceProfileTransformerInterface::class), self::createStub(DeviceProfilesTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), $localizationTransformer, new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($localization, $api->getTranslations('test-device-profile-id', 'ko'));
        self::assertSame($localization, $api->getTranslations('test-device-profile-id', 'ko', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetTranslationsUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = new DeviceProfileApi($requestSender, self::createStub(DeviceProfileTransformerInterface::class), self::createStub(DeviceProfilesTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DeviceProfileApiInterface::UNEXPECTED_RESPONSE);
        $api->getTranslations('test-device-profile-id', 'ko', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateDeviceProfile(): void
    {
        $data = ['test-profile-data'];

        $request = (new UpdateDeviceProfileRequest())->setPresentationId('test-presentation-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(DeviceProfileApiInterface::API_URL_SPRINTF, 'test-profile-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $updateDeviceProfileRequestSerializer = self::createMock(UpdateDeviceProfileRequestSerializerInterface::class);
        $updateDeviceProfileRequestSerializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $profile = self::createStub(DeviceProfileInterface::class);

        $deviceProfileTransformer = self::createMock(DeviceProfileTransformerInterface::class);
        $deviceProfileTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($profile);

        $api = new DeviceProfileApi($requestSender, $deviceProfileTransformer, self::createStub(DeviceProfilesTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), $updateDeviceProfileRequestSerializer, new RequestUrlBuilder());
        $actual = $api->updateDeviceProfile('test-profile-id', $request);

        self::assertSame($profile, $actual);
    }

    /**
     * updateDeviceProfile() refreshes the cached copy of this profile, so a
     * subsequent getOneById() for the same id is served from it.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateDeviceProfilePopulatesCache(): void
    {
        $profile = self::createStub(DeviceProfileInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('put')
            ->willReturn(['test-profile-data']);

        $deviceProfileTransformer = self::createMock(DeviceProfileTransformerInterface::class);
        $deviceProfileTransformer->expects(self::once())
            ->method('transform')
            ->willReturn($profile);

        $api = new DeviceProfileApi($requestSender, $deviceProfileTransformer, self::createStub(DeviceProfilesTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        self::assertSame($profile, $api->updateDeviceProfile('test-profile-id', new UpdateDeviceProfileRequest()));
        self::assertSame($profile, $api->getOneById('test-profile-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateDeviceProfileUnexpectedResponse(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn([]);

        $api = new DeviceProfileApi($requestSender, self::createStub(DeviceProfileTransformerInterface::class), self::createStub(DeviceProfilesTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateDeviceProfileRequestSerializerInterface::class), self::createStub(UpdateDeviceProfileRequestSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DeviceProfileApiInterface::UNEXPECTED_RESPONSE);
        $api->updateDeviceProfile('test-profile-id', new UpdateDeviceProfileRequest());
    }
}
