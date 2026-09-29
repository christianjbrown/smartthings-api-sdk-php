<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\CapabilityApi;
use ChristianBrown\SmartThings\Api\CapabilityApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AttributeDataSchema;
use ChristianBrown\SmartThings\Model\AttributeProperties;
use ChristianBrown\SmartThings\Model\AttributeSchema;
use ChristianBrown\SmartThings\Model\AttributeUnitSchema;
use ChristianBrown\SmartThings\Model\AttributeValueSchema;
use ChristianBrown\SmartThings\Model\CapabilityArgumentI18n;
use ChristianBrown\SmartThings\Model\CapabilityArgumentLocalization;
use ChristianBrown\SmartThings\Model\CapabilityAttribute;
use ChristianBrown\SmartThings\Model\CapabilityAttributeLabel;
use ChristianBrown\SmartThings\Model\CapabilityAttributeLocalization;
use ChristianBrown\SmartThings\Model\CapabilityCommand;
use ChristianBrown\SmartThings\Model\CapabilityCommandLocalization;
use ChristianBrown\SmartThings\Model\CapabilityInterface;
use ChristianBrown\SmartThings\Model\CapabilityLocalizationRequest;
use ChristianBrown\SmartThings\Model\CapabilityLocalizationRequestInterface;
use ChristianBrown\SmartThings\Model\CapabilityNamespaceInterface;
use ChristianBrown\SmartThings\Model\CapabilityPresentationInterface;
use ChristianBrown\SmartThings\Model\CommandArgument;
use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequest;
use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequestInterface;
use ChristianBrown\SmartThings\Model\CreateCapabilityRequest;
use ChristianBrown\SmartThings\Model\CreateCapabilityRequestInterface;
use ChristianBrown\SmartThings\Model\EnumCommand;
use ChristianBrown\SmartThings\Model\LocaleReferenceInterface;
use ChristianBrown\SmartThings\Model\LocalizationInterface;
use ChristianBrown\SmartThings\Model\UpdateCapabilityPresentationRequest;
use ChristianBrown\SmartThings\Model\UpdateCapabilityPresentationRequestInterface;
use ChristianBrown\SmartThings\Model\UpdateCapabilityRequest;
use ChristianBrown\SmartThings\Model\UpdateCapabilityRequestInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityLocalizationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CapabilityLocalizationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateCapabilityPresentationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateCapabilityPresentationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateCapabilityRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateCapabilityRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilitiesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityNamespacesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityPresentationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocaleReferencesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocalizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(UpdateCapabilityPresentationRequestSerializer::class)]
#[CoversClass(UpdateCapabilityPresentationRequest::class)]
#[CoversClass(CreateCapabilityPresentationRequestSerializer::class)]
#[CoversClass(CreateCapabilityPresentationRequest::class)]
#[CoversClass(CapabilityLocalizationRequestSerializer::class)]
#[CoversClass(CapabilityArgumentI18n::class)]
#[CoversClass(CapabilityArgumentLocalization::class)]
#[CoversClass(CapabilityCommandLocalization::class)]
#[CoversClass(CapabilityAttributeLabel::class)]
#[CoversClass(CapabilityAttributeLocalization::class)]
#[CoversClass(CapabilityLocalizationRequest::class)]
#[CoversClass(UpdateCapabilityRequestSerializer::class)]
#[CoversClass(UpdateCapabilityRequest::class)]
#[CoversClass(CreateCapabilityRequestSerializer::class)]
#[CoversClass(CommandArgument::class)]
#[CoversClass(CapabilityCommand::class)]
#[CoversClass(EnumCommand::class)]
#[CoversClass(AttributeDataSchema::class)]
#[CoversClass(AttributeUnitSchema::class)]
#[CoversClass(AttributeValueSchema::class)]
#[CoversClass(AttributeProperties::class)]
#[CoversClass(AttributeSchema::class)]
#[CoversClass(CapabilityAttribute::class)]
#[CoversClass(CreateCapabilityRequest::class)]
#[CoversClass(CapabilityApi::class)]
#[CoversClass(Token::class)]
final class CapabilityApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateCapability(): void
    {
        $data = ['test-data'];

        $request = self::createStub(CreateCapabilityRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                CapabilityApiInterface::API_URL,
                [CapabilityApiInterface::KEY_NAMESPACE => 'test-namespace'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                    ApiInterface::HEADER_KEY_ORGANIZATION => 'test-organization-id',
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(CreateCapabilityRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(CapabilityInterface::class);

        $transformer = self::createMock(CapabilityTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new CapabilityApi($requestSender, $transformer, self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), $serializer);
        $actual = $api->createCapability($request, 'test-namespace', 'test-organization-id');

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateCapabilityInvalidatesListCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn([CapabilityApiInterface::KEY_ITEMS => ['test-item']]);
        $requestSender->expects(self::once())->method('post')
            ->willReturn(['test-data']);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $api->getMultiple();
        $api->createCapability(self::createStub(CreateCapabilityRequestInterface::class));
        $api->getMultiple();

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateCapabilityLocalization(): void
    {
        $data = ['test-data'];

        $request = self::createStub(CapabilityLocalizationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_LOCALES_SPRINTF, 'test-capability-id', 3),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(CapabilityLocalizationRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(LocalizationInterface::class);

        $transformer = self::createMock(LocalizationTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), $transformer, new Token('test-api-token'), null, null, $serializer);
        $actual = $api->createCapabilityLocalization('test-capability-id', 3, $request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateCapabilityLocalizationUnexpectedResponse(): void
    {
        $request = self::createStub(CapabilityLocalizationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(CapabilityApiInterface::UNEXPECTED_RESPONSE);
        $api->createCapabilityLocalization('test-capability-id', 3, $request);
    }

    /**
     * Without an injected serializer the default one is used.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateCapabilityLocalizationUsesDefaultSerializer(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn(['test-data']);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $api->createCapabilityLocalization('test-capability-id', 3, new CapabilityLocalizationRequest('test-tag'));

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateCapabilityUnexpectedResponse(): void
    {
        $request = self::createStub(CreateCapabilityRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(CapabilityApiInterface::UNEXPECTED_RESPONSE);
        $api->createCapability($request);
    }

    /**
     * Without an injected serializer the default one is used.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateCapabilityUsesDefaultSerializer(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn(['test-data']);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $api->createCapability(new CreateCapabilityRequest('test-name'));

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateCapabilityWithoutOptionalParameters(): void
    {
        $data = ['test-data'];

        $request = self::createStub(CreateCapabilityRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                CapabilityApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(CreateCapabilityRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(CapabilityInterface::class);

        $transformer = self::createMock(CapabilityTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new CapabilityApi($requestSender, $transformer, self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), $serializer);
        $actual = $api->createCapability($request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateCustomCapabilityPresentation(): void
    {
        $data = ['test-data'];

        $request = self::createStub(CreateCapabilityPresentationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_PRESENTATION_SPRINTF, 'test-capability-id', 3),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                    ApiInterface::HEADER_KEY_ORGANIZATION => 'test-organization-id',
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(CreateCapabilityPresentationRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(CapabilityPresentationInterface::class);

        $transformer = self::createMock(CapabilityPresentationTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), $transformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), null, null, null, $serializer);
        $actual = $api->createCustomCapabilityPresentation('test-capability-id', 3, $request, 'test-organization-id');

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateCustomCapabilityPresentationUnexpectedResponse(): void
    {
        $request = self::createStub(CreateCapabilityPresentationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(CapabilityApiInterface::UNEXPECTED_RESPONSE);
        $api->createCustomCapabilityPresentation('test-capability-id', 3, $request);
    }

    /**
     * Without an injected serializer the default one is used.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateCustomCapabilityPresentationUsesDefaultSerializer(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn(['test-data']);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $api->createCustomCapabilityPresentation('test-capability-id', 3, new CreateCapabilityPresentationRequest('test-id'));

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateCustomCapabilityPresentationWithoutOptionalParameters(): void
    {
        $data = ['test-data'];

        $request = self::createStub(CreateCapabilityPresentationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_PRESENTATION_SPRINTF, 'test-capability-id', 3),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(CreateCapabilityPresentationRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(CapabilityPresentationInterface::class);

        $transformer = self::createMock(CapabilityPresentationTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), $transformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), null, null, null, $serializer);
        $actual = $api->createCustomCapabilityPresentation('test-capability-id', 3, $request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteCapability(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_SPRINTF, 'test-capability-id', 3),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                    ApiInterface::HEADER_KEY_ORGANIZATION => 'test-organization-id',
                ]
            )
            ->willReturn([]);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $api->deleteCapability('test-capability-id', 3, 'test-organization-id');

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteCapabilityInvalidatesCaches(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn(['test-data']);
        $requestSender->expects(self::once())->method('delete')
            ->willReturn([]);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $api->getOneByIdAndVersion('test-capability-id', 3);
        $api->deleteCapability('test-capability-id', 3);
        $api->getOneByIdAndVersion('test-capability-id', 3);

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteCapabilityWithoutOptionalParameters(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_SPRINTF, 'test-capability-id', 3),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $api->deleteCapability('test-capability-id', 3);

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetLocales(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_LOCALES_SPRINTF, 'switch', 1),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $locales = [self::createStub(LocaleReferenceInterface::class)];

        $localeReferencesTransformer = self::createMock(LocaleReferencesTransformerInterface::class);
        $localeReferencesTransformer->expects(self::once())->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($locales);

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), $localeReferencesTransformer, self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        self::assertSame($locales, $capabilityApi->getLocales('switch', 1));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetLocalesCaches(): void
    {
        $locales = [self::createStub(LocaleReferenceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([CapabilityApiInterface::KEY_ITEMS => ['test-item-1']]);

        $localeReferencesTransformer = self::createMock(LocaleReferencesTransformerInterface::class);
        $localeReferencesTransformer->expects(self::once())->method('transform')->willReturn($locales);

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), $localeReferencesTransformer, self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        // Second call for the same id and version is served from the cache without hitting the API.
        self::assertSame($locales, $capabilityApi->getLocales('switch', 1));
        self::assertSame($locales, $capabilityApi->getLocales('switch', 1));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetLocalesSkipsCache(): void
    {
        $locales = [self::createStub(LocaleReferenceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn([CapabilityApiInterface::KEY_ITEMS => ['test-item-1']]);

        $localeReferencesTransformer = self::createMock(LocaleReferencesTransformerInterface::class);
        $localeReferencesTransformer->expects(self::exactly(2))->method('transform')->willReturn($locales);

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), $localeReferencesTransformer, self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($locales, $capabilityApi->getLocales('switch', 1));
        self::assertSame($locales, $capabilityApi->getLocales('switch', 1, true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[CapabilityApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[CapabilityApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetLocalesUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn($data);

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CapabilityApiInterface::UNEXPECTED_RESPONSE_SPRINTF, CapabilityApiInterface::KEY_ITEMS));
        $capabilityApi->getLocales('switch', 1, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                CapabilityApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capabilities = [self::createStub(CapabilityInterface::class), self::createStub(CapabilityInterface::class)];

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $actual = $capabilityApi->getMultiple();

        self::assertSame($capabilities, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleByNamespace(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_NAMESPACE_SPRINTF, 'test-namespace'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $actual = $capabilityApi->getMultipleByNamespace('test-namespace');

        self::assertSame($capabilities, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleByNamespaceCaches(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        // Second call for the same namespace is served from the cache without hitting the API.
        self::assertSame($capabilities, $capabilityApi->getMultipleByNamespace('test-namespace'));
        self::assertSame($capabilities, $capabilityApi->getMultipleByNamespace('test-namespace'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../capabilities'])]
    public function testGetMultipleByNamespaceEncodesNamespace(string $namespace): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_NAMESPACE_SPRINTF, rawurlencode($namespace)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $actual = $capabilityApi->getMultipleByNamespace($namespace);

        self::assertSame($capabilities, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleByNamespaceSkipsCache(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($capabilities, $capabilityApi->getMultipleByNamespace('test-namespace'));
        self::assertSame($capabilities, $capabilityApi->getMultipleByNamespace('test-namespace', true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[CapabilityApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[CapabilityApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleByNamespaceUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);
        $capabilitiesTransformer = self::createStub(CapabilitiesTransformerInterface::class);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CapabilityApiInterface::UNEXPECTED_RESPONSE_SPRINTF, CapabilityApiInterface::KEY_ITEMS));
        $capabilityApi->getMultipleByNamespace('test-namespace', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        // Second call is served from the cache without hitting the API.
        self::assertSame($capabilities, $capabilityApi->getMultiple());
        self::assertSame($capabilities, $capabilityApi->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($capabilities, $capabilityApi->getMultiple());
        self::assertSame($capabilities, $capabilityApi->getMultiple(true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[CapabilityApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[CapabilityApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                CapabilityApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);
        $capabilitiesTransformer = self::createStub(CapabilitiesTransformerInterface::class);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CapabilityApiInterface::UNEXPECTED_RESPONSE_SPRINTF, CapabilityApiInterface::KEY_ITEMS));
        $capabilityApi->getMultiple($skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetNamespaces(): void
    {
        $data = ['test-namespace-item-1', 'test-namespace-item-2'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                CapabilityApiInterface::API_URL_NAMESPACES,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $namespaces = [self::createStub(CapabilityNamespaceInterface::class)];

        $namespacesTransformer = self::createMock(CapabilityNamespacesTransformerInterface::class);
        $namespacesTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($namespaces);

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), $namespacesTransformer, self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $actual = $capabilityApi->getNamespaces();

        self::assertSame($namespaces, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetNamespacesCaches(): void
    {
        $data = ['test-namespace-item-1'];

        $namespaces = [self::createStub(CapabilityNamespaceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $namespacesTransformer = self::createMock(CapabilityNamespacesTransformerInterface::class);
        $namespacesTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($namespaces);

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), $namespacesTransformer, self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        // Second call is served from the cache without hitting the API.
        self::assertSame($namespaces, $capabilityApi->getNamespaces());
        self::assertSame($namespaces, $capabilityApi->getNamespaces());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetNamespacesSkipsCache(): void
    {
        $data = ['test-namespace-item-1'];

        $namespaces = [self::createStub(CapabilityNamespaceInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $namespacesTransformer = self::createMock(CapabilityNamespacesTransformerInterface::class);
        $namespacesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($namespaces);

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), $namespacesTransformer, self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($namespaces, $capabilityApi->getNamespaces());
        self::assertSame($namespaces, $capabilityApi->getNamespaces(true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetNamespacesUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn([]);

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(CapabilityApiInterface::UNEXPECTED_RESPONSE);
        $capabilityApi->getNamespaces($skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdAndVersion(): void
    {
        $data = ['test-capability-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_SPRINTF, 'test-capability-id', 1),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capability = self::createStub(CapabilityInterface::class);

        $capabilityTransformer = self::createMock(CapabilityTransformerInterface::class);
        $capabilityTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($capability);

        $capabilitiesTransformer = self::createStub(CapabilitiesTransformerInterface::class);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $actual = $capabilityApi->getOneByIdAndVersion('test-capability-id', 1);

        self::assertSame($capability, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdAndVersionCaches(): void
    {
        $data = ['test-capability-data'];

        $capability = self::createStub(CapabilityInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createMock(CapabilityTransformerInterface::class);
        $capabilityTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($capability);

        $capabilitiesTransformer = self::createStub(CapabilitiesTransformerInterface::class);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        // Second call for the same id/version is served from the cache without hitting the API.
        self::assertSame($capability, $capabilityApi->getOneByIdAndVersion('test-capability-id', 1));
        self::assertSame($capability, $capabilityApi->getOneByIdAndVersion('test-capability-id', 1));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c', 2])]
    #[TestWith(['../../capabilities', 3])]
    public function testGetOneByIdAndVersionEncodesId(string $capabilityId, int $version): void
    {
        $data = ['test-capability-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_SPRINTF, rawurlencode($capabilityId), $version),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capability = self::createStub(CapabilityInterface::class);

        $capabilityTransformer = self::createMock(CapabilityTransformerInterface::class);
        $capabilityTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($capability);

        $capabilitiesTransformer = self::createStub(CapabilitiesTransformerInterface::class);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $actual = $capabilityApi->getOneByIdAndVersion($capabilityId, $version);

        self::assertSame($capability, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdAndVersionSkipsCache(): void
    {
        $data = ['test-capability-data'];

        $capability = self::createStub(CapabilityInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createMock(CapabilityTransformerInterface::class);
        $capabilityTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($capability);

        $capabilitiesTransformer = self::createStub(CapabilitiesTransformerInterface::class);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($capability, $capabilityApi->getOneByIdAndVersion('test-capability-id', 1));
        self::assertSame($capability, $capabilityApi->getOneByIdAndVersion('test-capability-id', 1, true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetOneByIdAndVersionUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_SPRINTF, 'test-capability-id', 1),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);
        $capabilitiesTransformer = self::createStub(CapabilitiesTransformerInterface::class);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(CapabilityApiInterface::UNEXPECTED_RESPONSE);
        $capabilityApi->getOneByIdAndVersion('test-capability-id', 1, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetPresentation(): void
    {
        $data = ['test-presentation-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_PRESENTATION_SPRINTF, 'switch', 1),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $presentation = self::createStub(CapabilityPresentationInterface::class);

        $presentationTransformer = self::createMock(CapabilityPresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), $presentationTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $actual = $capabilityApi->getPresentation('switch', 1);

        self::assertSame($presentation, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetPresentationCaches(): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(CapabilityPresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $presentationTransformer = self::createMock(CapabilityPresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), $presentationTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        // Second call for the same id and version is served from the cache without hitting the API.
        self::assertSame($presentation, $capabilityApi->getPresentation('switch', 1));
        self::assertSame($presentation, $capabilityApi->getPresentation('switch', 1));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../capabilities'])]
    public function testGetPresentationEncodesId(string $capabilityId): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(CapabilityPresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_PRESENTATION_SPRINTF, rawurlencode($capabilityId), 1),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $presentationTransformer = self::createMock(CapabilityPresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), $presentationTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $actual = $capabilityApi->getPresentation($capabilityId, 1);

        self::assertSame($presentation, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetPresentationSkipsCache(): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(CapabilityPresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $presentationTransformer = self::createMock(CapabilityPresentationTransformerInterface::class);
        $presentationTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), $presentationTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($presentation, $capabilityApi->getPresentation('switch', 1));
        self::assertSame($presentation, $capabilityApi->getPresentation('switch', 1, true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetPresentationUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn([]);

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(CapabilityApiInterface::UNEXPECTED_RESPONSE);
        $capabilityApi->getPresentation('switch', 1, $skipCache);
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
                sprintf(CapabilityApiInterface::API_URL_TRANSLATIONS_SPRINTF, 'switch', 1, 'ko'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $localization = self::createStub(LocalizationInterface::class);

        $localizationTransformer = self::createMock(LocalizationTransformerInterface::class);
        $localizationTransformer->expects(self::once())->method('transform')->with($data)->willReturn($localization);

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), $localizationTransformer, new Token('test-api-token'));

        self::assertSame($localization, $capabilityApi->getTranslations('switch', 1, 'ko'));
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

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), $localizationTransformer, new Token('test-api-token'));

        // Second call for the same id, version and tag is served from the cache without hitting the API.
        self::assertSame($localization, $capabilityApi->getTranslations('switch', 1, 'ko'));
        self::assertSame($localization, $capabilityApi->getTranslations('switch', 1, 'ko'));
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

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), $localizationTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($localization, $capabilityApi->getTranslations('switch', 1, 'ko'));
        self::assertSame($localization, $capabilityApi->getTranslations('switch', 1, 'ko', true));
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

        $capabilityApi = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(CapabilityApiInterface::UNEXPECTED_RESPONSE);
        $capabilityApi->getTranslations('switch', 1, 'ko', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetVersions(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_VERSIONS_SPRINTF, 'test-capability-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $actual = $capabilityApi->getVersions('test-capability-id');

        self::assertSame($capabilities, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetVersionsCaches(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        // Second call for the same capability id is served from the cache without hitting the API.
        self::assertSame($capabilities, $capabilityApi->getVersions('test-capability-id'));
        self::assertSame($capabilities, $capabilityApi->getVersions('test-capability-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../capabilities'])]
    public function testGetVersionsEncodesId(string $capabilityId): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_VERSIONS_SPRINTF, rawurlencode($capabilityId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::once())->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $actual = $capabilityApi->getVersions($capabilityId);

        self::assertSame($capabilities, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetVersionsSkipsCache(): void
    {
        $data = [
            CapabilityApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $capabilities = [self::createStub(CapabilityInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);

        $capabilitiesTransformer = self::createMock(CapabilitiesTransformerInterface::class);
        $capabilitiesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[CapabilityApiInterface::KEY_ITEMS])
            ->willReturn($capabilities);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($capabilities, $capabilityApi->getVersions('test-capability-id'));
        self::assertSame($capabilities, $capabilityApi->getVersions('test-capability-id', true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[CapabilityApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[CapabilityApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetVersionsUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn($data);

        $capabilityTransformer = self::createStub(CapabilityTransformerInterface::class);
        $capabilitiesTransformer = self::createStub(CapabilitiesTransformerInterface::class);

        $capabilityApi = new CapabilityApi($requestSender, $capabilityTransformer, $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CapabilityApiInterface::UNEXPECTED_RESPONSE_SPRINTF, CapabilityApiInterface::KEY_ITEMS));
        $capabilityApi->getVersions('test-capability-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testPatchCapabilityLocalization(): void
    {
        $data = ['test-data'];

        $request = self::createStub(CapabilityLocalizationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('patch')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_TRANSLATIONS_SPRINTF, 'test-capability-id', 3, 'test-locale'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(CapabilityLocalizationRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(LocalizationInterface::class);

        $transformer = self::createMock(LocalizationTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), $transformer, new Token('test-api-token'), null, null, $serializer);
        $actual = $api->patchCapabilityLocalization('test-capability-id', 3, 'test-locale', $request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testPatchCapabilityLocalizationUnexpectedResponse(): void
    {
        $request = self::createStub(CapabilityLocalizationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('patch')
            ->willReturn([]);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(CapabilityApiInterface::UNEXPECTED_RESPONSE);
        $api->patchCapabilityLocalization('test-capability-id', 3, 'test-locale', $request);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateCapability(): void
    {
        $data = ['test-data'];

        $request = self::createStub(UpdateCapabilityRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_SPRINTF, 'test-capability-id', 3),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                    ApiInterface::HEADER_KEY_ORGANIZATION => 'test-organization-id',
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(UpdateCapabilityRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(CapabilityInterface::class);

        $transformer = self::createMock(CapabilityTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new CapabilityApi($requestSender, $transformer, self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), null, $serializer);
        $actual = $api->updateCapability('test-capability-id', 3, $request, 'test-organization-id');

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateCapabilityLocalization(): void
    {
        $data = ['test-data'];

        $request = self::createStub(CapabilityLocalizationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_TRANSLATIONS_SPRINTF, 'test-capability-id', 3, 'test-locale'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(CapabilityLocalizationRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(LocalizationInterface::class);

        $transformer = self::createMock(LocalizationTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), $transformer, new Token('test-api-token'), null, null, $serializer);
        $actual = $api->updateCapabilityLocalization('test-capability-id', 3, 'test-locale', $request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateCapabilityLocalizationUnexpectedResponse(): void
    {
        $request = self::createStub(CapabilityLocalizationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn([]);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(CapabilityApiInterface::UNEXPECTED_RESPONSE);
        $api->updateCapabilityLocalization('test-capability-id', 3, 'test-locale', $request);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateCapabilityUnexpectedResponse(): void
    {
        $request = self::createStub(UpdateCapabilityRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn([]);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(CapabilityApiInterface::UNEXPECTED_RESPONSE);
        $api->updateCapability('test-capability-id', 3, $request);
    }

    /**
     * Without an injected serializer the default one is used.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateCapabilityUsesDefaultSerializer(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn(['test-data']);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $api->updateCapability('test-capability-id', 3, new UpdateCapabilityRequest());

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateCapabilityWithoutOptionalParameters(): void
    {
        $data = ['test-data'];

        $request = self::createStub(UpdateCapabilityRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_SPRINTF, 'test-capability-id', 3),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(UpdateCapabilityRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(CapabilityInterface::class);

        $transformer = self::createMock(CapabilityTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new CapabilityApi($requestSender, $transformer, self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), null, $serializer);
        $actual = $api->updateCapability('test-capability-id', 3, $request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateCustomCapabilityPresentation(): void
    {
        $data = ['test-data'];

        $request = self::createStub(UpdateCapabilityPresentationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_PRESENTATION_SPRINTF, 'test-capability-id', 3),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                    ApiInterface::HEADER_KEY_ORGANIZATION => 'test-organization-id',
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(UpdateCapabilityPresentationRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(CapabilityPresentationInterface::class);

        $transformer = self::createMock(CapabilityPresentationTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), $transformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), null, null, null, null, $serializer);
        $actual = $api->updateCustomCapabilityPresentation('test-capability-id', 3, $request, 'test-organization-id');

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateCustomCapabilityPresentationUnexpectedResponse(): void
    {
        $request = self::createStub(UpdateCapabilityPresentationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn([]);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(CapabilityApiInterface::UNEXPECTED_RESPONSE);
        $api->updateCustomCapabilityPresentation('test-capability-id', 3, $request);
    }

    /**
     * Without an injected serializer the default one is used.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateCustomCapabilityPresentationUsesDefaultSerializer(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn(['test-data']);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'));
        $api->updateCustomCapabilityPresentation('test-capability-id', 3, new UpdateCapabilityPresentationRequest());

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateCustomCapabilityPresentationWithoutOptionalParameters(): void
    {
        $data = ['test-data'];

        $request = self::createStub(UpdateCapabilityPresentationRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(CapabilityApiInterface::API_URL_PRESENTATION_SPRINTF, 'test-capability-id', 3),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(UpdateCapabilityPresentationRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(CapabilityPresentationInterface::class);

        $transformer = self::createMock(CapabilityPresentationTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), $transformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), null, null, null, null, $serializer);
        $actual = $api->updateCustomCapabilityPresentation('test-capability-id', 3, $request);

        self::assertSame($model, $actual);
    }
}
