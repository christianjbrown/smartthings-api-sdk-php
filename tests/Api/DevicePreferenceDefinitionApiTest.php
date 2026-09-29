<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\DevicePreferenceDefinitionApi;
use ChristianBrown\SmartThings\Api\DevicePreferenceDefinitionApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DevicePreferenceDefinitionInterface;
use ChristianBrown\SmartThings\Model\LocaleReferenceInterface;
use ChristianBrown\SmartThings\Model\LocalizationInterface;
use ChristianBrown\SmartThings\Model\PreferenceLocalizationRequestInterface;
use ChristianBrown\SmartThings\Model\PreferenceRequest;
use ChristianBrown\SmartThings\Serializer\PreferenceLocalizationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PreferenceRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DevicePreferenceDefinitionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocaleReferencesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocalizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(DevicePreferenceDefinitionApi::class)]
#[CoversClass(PreferenceRequest::class)]
#[CoversClass(Token::class)]
final class DevicePreferenceDefinitionApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreatePreference(): void
    {
        $data = ['test-preference-data'];

        $request = new PreferenceRequest('tempOffset', 'Temperature Offset', 'number', ['minimum' => -10.0]);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                DevicePreferenceDefinitionApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $preferenceRequestSerializer = self::createMock(PreferenceRequestSerializerInterface::class);
        $preferenceRequestSerializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $definition = self::createStub(DevicePreferenceDefinitionInterface::class);

        $devicePreferenceDefinitionTransformer = self::createMock(DevicePreferenceDefinitionTransformerInterface::class);
        $devicePreferenceDefinitionTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($definition);

        $api = new DevicePreferenceDefinitionApi($requestSender, $devicePreferenceDefinitionTransformer, self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), $preferenceRequestSerializer, self::createStub(PreferenceLocalizationRequestSerializerInterface::class));
        $actual = $api->createPreference($request);

        self::assertSame($definition, $actual);
    }

    /**
     * createPreference() invalidates the cached preference lists, so a subsequent
     * getMultiple() call hits the API again instead of returning a stale list.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreatePreferenceInvalidatesListCache(): void
    {
        $definition = self::createStub(DevicePreferenceDefinitionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn([DevicePreferenceDefinitionApiInterface::KEY_ITEMS => ['test-item']]);
        $requestSender->expects(self::once())->method('post')
            ->willReturn(['test-preference-data']);

        $devicePreferenceDefinitionTransformer = self::createStub(DevicePreferenceDefinitionTransformerInterface::class);
        $devicePreferenceDefinitionTransformer->method('transform')
            ->willReturn($definition);

        $devicePreferenceDefinitionsTransformer = self::createStub(DevicePreferenceDefinitionsTransformerInterface::class);
        $devicePreferenceDefinitionsTransformer->method('transform')
            ->willReturn([$definition]);

        $api = new DevicePreferenceDefinitionApi($requestSender, $devicePreferenceDefinitionTransformer, $devicePreferenceDefinitionsTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        $api->getMultiple();
        $api->createPreference(new PreferenceRequest('tempOffset', 'Temperature Offset', 'number', ['minimum' => -10.0]));
        $api->getMultiple();
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreatePreferenceLocalization(): void
    {
        $data = ['test-data'];

        $request = self::createStub(PreferenceLocalizationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                sprintf(DevicePreferenceDefinitionApiInterface::API_URL_PREFERENCE_LOCALIZATIONS_SPRINTF, 'test-preference-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(PreferenceLocalizationRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(LocalizationInterface::class);

        $transformer = self::createMock(LocalizationTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), $transformer, new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), $serializer);
        $actual = $api->createPreferenceLocalization('test-preference-id', $request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreatePreferenceLocalizationUnexpectedResponse(): void
    {
        $request = self::createStub(PreferenceLocalizationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DevicePreferenceDefinitionApiInterface::UNEXPECTED_RESPONSE);
        $api->createPreferenceLocalization('test-preference-id', $request);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreatePreferenceUnexpectedResponse(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DevicePreferenceDefinitionApiInterface::UNEXPECTED_RESPONSE);
        $api->createPreference(new PreferenceRequest('tempOffset', 'Temperature Offset', 'number', ['minimum' => -10.0]));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeletePreferenceById(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(
                sprintf(DevicePreferenceDefinitionApiInterface::API_URL_SPRINTF, 'test-preference-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));
        $api->deletePreferenceById('test-preference-id');

        $this->addToAssertionCount(1);
    }

    /**
     * deletePreferenceById() invalidates the cached copy of this preference and the
     * cached preference lists, so subsequent lookups hit the API again.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeletePreferenceByIdInvalidatesCaches(): void
    {
        $definition = self::createStub(DevicePreferenceDefinitionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn(['test-preference-data']);
        $requestSender->expects(self::once())->method('delete')
            ->willReturn([]);

        $devicePreferenceDefinitionTransformer = self::createStub(DevicePreferenceDefinitionTransformerInterface::class);
        $devicePreferenceDefinitionTransformer->method('transform')
            ->willReturn($definition);

        $api = new DevicePreferenceDefinitionApi($requestSender, $devicePreferenceDefinitionTransformer, self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        $api->getOneById('test-preference-id');
        $api->deletePreferenceById('test-preference-id');
        $api->getOneById('test-preference-id');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetLocales(): void
    {
        $data = [
            DevicePreferenceDefinitionApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DevicePreferenceDefinitionApiInterface::API_URL_LOCALES_SPRINTF, 'test-preference-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $locales = [self::createStub(LocaleReferenceInterface::class)];

        $localeReferencesTransformer = self::createMock(LocaleReferencesTransformerInterface::class);
        $localeReferencesTransformer->expects(self::once())->method('transform')
            ->with($data[DevicePreferenceDefinitionApiInterface::KEY_ITEMS])
            ->willReturn($locales);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), $localeReferencesTransformer, self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        self::assertSame($locales, $api->getLocales('test-preference-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetLocalesCaches(): void
    {
        $locales = [self::createStub(LocaleReferenceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([DevicePreferenceDefinitionApiInterface::KEY_ITEMS => ['test-item-1']]);

        $localeReferencesTransformer = self::createMock(LocaleReferencesTransformerInterface::class);
        $localeReferencesTransformer->expects(self::once())->method('transform')->willReturn($locales);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), $localeReferencesTransformer, self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        // Second call for the same id is served from the cache without hitting the API.
        self::assertSame($locales, $api->getLocales('test-preference-id'));
        self::assertSame($locales, $api->getLocales('test-preference-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetLocalesSkipsCache(): void
    {
        $locales = [self::createStub(LocaleReferenceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn([DevicePreferenceDefinitionApiInterface::KEY_ITEMS => ['test-item-1']]);

        $localeReferencesTransformer = self::createMock(LocaleReferencesTransformerInterface::class);
        $localeReferencesTransformer->expects(self::exactly(2))->method('transform')->willReturn($locales);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), $localeReferencesTransformer, self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($locales, $api->getLocales('test-preference-id'));
        self::assertSame($locales, $api->getLocales('test-preference-id', true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[DevicePreferenceDefinitionApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[DevicePreferenceDefinitionApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetLocalesUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn($data);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DevicePreferenceDefinitionApiInterface::UNEXPECTED_RESPONSE_SPRINTF, DevicePreferenceDefinitionApiInterface::KEY_ITEMS));
        $api->getLocales('test-preference-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            DevicePreferenceDefinitionApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DevicePreferenceDefinitionApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $definitions = [self::createStub(DevicePreferenceDefinitionInterface::class), self::createStub(DevicePreferenceDefinitionInterface::class)];

        $definitionsTransformer = self::createMock(DevicePreferenceDefinitionsTransformerInterface::class);
        $definitionsTransformer->expects(self::once())->method('transform')
            ->with($data[DevicePreferenceDefinitionApiInterface::KEY_ITEMS])
            ->willReturn($definitions);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), $definitionsTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));
        $actual = $api->getMultiple();

        self::assertSame($definitions, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            DevicePreferenceDefinitionApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $definitions = [self::createStub(DevicePreferenceDefinitionInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $definitionsTransformer = self::createMock(DevicePreferenceDefinitionsTransformerInterface::class);
        $definitionsTransformer->expects(self::once())
            ->method('transform')
            ->with($data[DevicePreferenceDefinitionApiInterface::KEY_ITEMS])
            ->willReturn($definitions);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), $definitionsTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        // Second call with the same filter is served from the cache without hitting the API.
        self::assertSame($definitions, $api->getMultiple());
        self::assertSame($definitions, $api->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleFiltersByNamespace(): void
    {
        $data = [
            DevicePreferenceDefinitionApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DevicePreferenceDefinitionApiInterface::API_URL,
                [DevicePreferenceDefinitionApiInterface::KEY_NAMESPACE => 'test-namespace'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $definitions = [self::createStub(DevicePreferenceDefinitionInterface::class)];

        $definitionsTransformer = self::createMock(DevicePreferenceDefinitionsTransformerInterface::class);
        $definitionsTransformer->expects(self::once())->method('transform')
            ->with($data[DevicePreferenceDefinitionApiInterface::KEY_ITEMS])
            ->willReturn($definitions);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), $definitionsTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));
        $actual = $api->getMultiple('test-namespace');

        self::assertSame($definitions, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            DevicePreferenceDefinitionApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $definitions = [self::createStub(DevicePreferenceDefinitionInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $definitionsTransformer = self::createMock(DevicePreferenceDefinitionsTransformerInterface::class);
        $definitionsTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[DevicePreferenceDefinitionApiInterface::KEY_ITEMS])
            ->willReturn($definitions);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), $definitionsTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($definitions, $api->getMultiple());
        self::assertSame($definitions, $api->getMultiple(null, true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[DevicePreferenceDefinitionApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[DevicePreferenceDefinitionApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DevicePreferenceDefinitionApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DevicePreferenceDefinitionApiInterface::UNEXPECTED_RESPONSE_SPRINTF, DevicePreferenceDefinitionApiInterface::KEY_ITEMS));
        $api->getMultiple(null, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-definition-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DevicePreferenceDefinitionApiInterface::API_URL_SPRINTF, 'test-preference-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $definition = self::createStub(DevicePreferenceDefinitionInterface::class);

        $definitionTransformer = self::createMock(DevicePreferenceDefinitionTransformerInterface::class);
        $definitionTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($definition);

        $api = new DevicePreferenceDefinitionApi($requestSender, $definitionTransformer, self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));
        $actual = $api->getOneById('test-preference-id');

        self::assertSame($definition, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $data = ['test-definition-data'];

        $definition = self::createStub(DevicePreferenceDefinitionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $definitionTransformer = self::createMock(DevicePreferenceDefinitionTransformerInterface::class);
        $definitionTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($definition);

        $api = new DevicePreferenceDefinitionApi($requestSender, $definitionTransformer, self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        // Second call for the same id is served from the cache without hitting the API.
        self::assertSame($definition, $api->getOneById('test-preference-id'));
        self::assertSame($definition, $api->getOneById('test-preference-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../devicepreferences'])]
    public function testGetOneByIdEncodesId(string $preferenceId): void
    {
        $data = ['test-definition-data'];

        $definition = self::createStub(DevicePreferenceDefinitionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(DevicePreferenceDefinitionApiInterface::API_URL_SPRINTF, rawurlencode($preferenceId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $definitionTransformer = self::createMock(DevicePreferenceDefinitionTransformerInterface::class);
        $definitionTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($definition);

        $api = new DevicePreferenceDefinitionApi($requestSender, $definitionTransformer, self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));
        $actual = $api->getOneById($preferenceId);

        self::assertSame($definition, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $data = ['test-definition-data'];

        $definition = self::createStub(DevicePreferenceDefinitionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $definitionTransformer = self::createMock(DevicePreferenceDefinitionTransformerInterface::class);
        $definitionTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($definition);

        $api = new DevicePreferenceDefinitionApi($requestSender, $definitionTransformer, self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($definition, $api->getOneById('test-preference-id'));
        self::assertSame($definition, $api->getOneById('test-preference-id', true));
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
            ->willReturn([]);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DevicePreferenceDefinitionApiInterface::UNEXPECTED_RESPONSE);
        $api->getOneById('test-preference-id', $skipCache);
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
                sprintf(DevicePreferenceDefinitionApiInterface::API_URL_TRANSLATIONS_SPRINTF, 'test-preference-id', 'ko'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $localization = self::createStub(LocalizationInterface::class);

        $localizationTransformer = self::createMock(LocalizationTransformerInterface::class);
        $localizationTransformer->expects(self::once())->method('transform')->with($data)->willReturn($localization);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), $localizationTransformer, new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        self::assertSame($localization, $api->getTranslations('test-preference-id', 'ko'));
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

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), $localizationTransformer, new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        // Second call for the same id and locale is served from the cache without hitting the API.
        self::assertSame($localization, $api->getTranslations('test-preference-id', 'ko'));
        self::assertSame($localization, $api->getTranslations('test-preference-id', 'ko'));
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

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), $localizationTransformer, new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($localization, $api->getTranslations('test-preference-id', 'ko'));
        self::assertSame($localization, $api->getTranslations('test-preference-id', 'ko', true));
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

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DevicePreferenceDefinitionApiInterface::UNEXPECTED_RESPONSE);
        $api->getTranslations('test-preference-id', 'ko', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdatePreferenceById(): void
    {
        $data = ['test-preference-data'];

        $request = new PreferenceRequest('tempOffset', 'Temperature Offset', 'number', ['minimum' => -10.0]);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(DevicePreferenceDefinitionApiInterface::API_URL_SPRINTF, 'test-preference-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $preferenceRequestSerializer = self::createMock(PreferenceRequestSerializerInterface::class);
        $preferenceRequestSerializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $definition = self::createStub(DevicePreferenceDefinitionInterface::class);

        $devicePreferenceDefinitionTransformer = self::createMock(DevicePreferenceDefinitionTransformerInterface::class);
        $devicePreferenceDefinitionTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($definition);

        $api = new DevicePreferenceDefinitionApi($requestSender, $devicePreferenceDefinitionTransformer, self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), $preferenceRequestSerializer, self::createStub(PreferenceLocalizationRequestSerializerInterface::class));
        $actual = $api->updatePreferenceById('test-preference-id', $request);

        self::assertSame($definition, $actual);
    }

    /**
     * updatePreferenceById() refreshes the cached copy of this preference, so a
     * subsequent getOneById() for the same id is served from it.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdatePreferenceByIdPopulatesCache(): void
    {
        $definition = self::createStub(DevicePreferenceDefinitionInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('put')
            ->willReturn(['test-preference-data']);

        $devicePreferenceDefinitionTransformer = self::createMock(DevicePreferenceDefinitionTransformerInterface::class);
        $devicePreferenceDefinitionTransformer->expects(self::once())
            ->method('transform')
            ->willReturn($definition);

        $api = new DevicePreferenceDefinitionApi($requestSender, $devicePreferenceDefinitionTransformer, self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        self::assertSame($definition, $api->updatePreferenceById('test-preference-id', new PreferenceRequest('tempOffset', 'Temperature Offset', 'number', ['minimum' => -10.0])));
        self::assertSame($definition, $api->getOneById('test-preference-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdatePreferenceByIdUnexpectedResponse(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn([]);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DevicePreferenceDefinitionApiInterface::UNEXPECTED_RESPONSE);
        $api->updatePreferenceById('test-preference-id', new PreferenceRequest('tempOffset', 'Temperature Offset', 'number', ['minimum' => -10.0]));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdatePreferenceLocalization(): void
    {
        $data = ['test-data'];

        $request = self::createStub(PreferenceLocalizationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(DevicePreferenceDefinitionApiInterface::API_URL_PREFERENCE_LOCALIZATION_SPRINTF, 'test-preference-id', 'test-locale'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(PreferenceLocalizationRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(LocalizationInterface::class);

        $transformer = self::createMock(LocalizationTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), $transformer, new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), $serializer);
        $actual = $api->updatePreferenceLocalization('test-preference-id', 'test-locale', $request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdatePreferenceLocalizationUnexpectedResponse(): void
    {
        $request = self::createStub(PreferenceLocalizationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn([]);

        $api = new DevicePreferenceDefinitionApi($requestSender, self::createStub(DevicePreferenceDefinitionTransformerInterface::class), self::createStub(DevicePreferenceDefinitionsTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(PreferenceRequestSerializerInterface::class), self::createStub(PreferenceLocalizationRequestSerializerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(DevicePreferenceDefinitionApiInterface::UNEXPECTED_RESPONSE);
        $api->updatePreferenceLocalization('test-preference-id', 'test-locale', $request);
    }
}
