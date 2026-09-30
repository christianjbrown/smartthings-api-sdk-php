<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\CapabilityApi;
use ChristianBrown\SmartThings\Api\CapabilityApiInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Model\CapabilityInterface;
use ChristianBrown\SmartThings\Model\CapabilityPresentationInterface;
use ChristianBrown\SmartThings\Serializer\CapabilityLocalizationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityPresentationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\CreateCapabilityRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateCapabilityPresentationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateCapabilityRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilitiesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityNamespacesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityPresentationTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CapabilityTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocaleReferencesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocalizationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(CapabilityApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
final class CapabilityApiHeaderTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleByNamespaceSendsOrganizationAndCachesPerVariant(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [sprintf(CapabilityApiInterface::API_URL_NAMESPACE_SPRINTF, 'test.ns'), [], $this->headers(), [CapabilityApiInterface::KEY_ITEMS => ['plain']]],
                [sprintf(CapabilityApiInterface::API_URL_NAMESPACE_SPRINTF, 'test.ns'), [], $this->headers() + [ApiInterface::HEADER_KEY_ORGANIZATION => 'test-org'], [CapabilityApiInterface::KEY_ITEMS => ['variant']]],
            ]);
        $plain = [self::createStub(CapabilityInterface::class)];
        $variant = [self::createStub(CapabilityInterface::class)];
        $transformer = self::createStub(CapabilitiesTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $api = $this->api($requestSender, $transformer, self::createStub(CapabilityPresentationTransformerInterface::class));

        self::assertSame($plain, $api->getMultipleByNamespace('test.ns'));
        self::assertSame($variant, $api->getMultipleByNamespace('test.ns', false, 'test-org'));
        self::assertSame($plain, $api->getMultipleByNamespace('test.ns'));
        self::assertSame($variant, $api->getMultipleByNamespace('test.ns', false, 'test-org'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetPresentationSendsLanguageAndCachesPerVariant(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [sprintf(CapabilityApiInterface::API_URL_PRESENTATION_SPRINTF, 'test.capability', 1), [], $this->headers(), ['plain']],
                [sprintf(CapabilityApiInterface::API_URL_PRESENTATION_SPRINTF, 'test.capability', 1), [], $this->headers() + [ApiInterface::HEADER_KEY_ACCEPT_LANGUAGE => 'fr-FR'], ['variant']],
            ]);
        $plain = self::createStub(CapabilityPresentationInterface::class);
        $variant = self::createStub(CapabilityPresentationInterface::class);
        $transformer = self::createStub(CapabilityPresentationTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $api = $this->api($requestSender, self::createStub(CapabilitiesTransformerInterface::class), $transformer);

        self::assertSame($plain, $api->getPresentation('test.capability', 1));
        self::assertSame($variant, $api->getPresentation('test.capability', 1, false, 'fr-FR'));
        self::assertSame($plain, $api->getPresentation('test.capability', 1));
        self::assertSame($variant, $api->getPresentation('test.capability', 1, false, 'fr-FR'));
    }

    private function api(JsonApiRequestSenderInterface $requestSender, CapabilitiesTransformerInterface $capabilitiesTransformer, CapabilityPresentationTransformerInterface $capabilityPresentationTransformer): CapabilityApi
    {
        return new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), $capabilitiesTransformer, self::createStub(CapabilityNamespacesTransformerInterface::class), $capabilityPresentationTransformer, self::createStub(LocaleReferencesTransformerInterface::class), self::createStub(LocalizationTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateCapabilityRequestSerializerInterface::class), self::createStub(UpdateCapabilityRequestSerializerInterface::class), self::createStub(CapabilityLocalizationRequestSerializerInterface::class), self::createStub(CreateCapabilityPresentationRequestSerializerInterface::class), self::createStub(UpdateCapabilityPresentationRequestSerializerInterface::class), new RequestUrlBuilder());
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
