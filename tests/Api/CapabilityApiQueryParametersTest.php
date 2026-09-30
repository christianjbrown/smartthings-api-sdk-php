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
use ChristianBrown\SmartThings\Model\LocalizationInterface;
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
final class CapabilityApiQueryParametersTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetTranslationsSendsPresentationAndManufacturerAndCachesPerVariant(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [sprintf(CapabilityApiInterface::API_URL_TRANSLATIONS_SPRINTF, 'test.capability', 1, 'en'), [], $this->headers(), ['plain']],
                [sprintf(CapabilityApiInterface::API_URL_TRANSLATIONS_SPRINTF, 'test.capability', 1, 'en').'?presentationId=test-presentation&manufacturerName=test-maker', [], $this->headers(), ['variant']],
            ]);
        $plain = self::createStub(LocalizationInterface::class);
        $variant = self::createStub(LocalizationInterface::class);
        $transformer = self::createStub(LocalizationTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $api = $this->api($requestSender, $transformer);

        self::assertSame($plain, $api->getTranslations('test.capability', 1, 'en'));
        self::assertSame($variant, $api->getTranslations('test.capability', 1, 'en', false, 'test-presentation', 'test-maker'));
        self::assertSame($plain, $api->getTranslations('test.capability', 1, 'en'));
        self::assertSame($variant, $api->getTranslations('test.capability', 1, 'en', false, 'test-presentation', 'test-maker'));
    }

    private function api(JsonApiRequestSenderInterface $requestSender, LocalizationTransformerInterface $localizationTransformer): CapabilityApi
    {
        return new CapabilityApi($requestSender, self::createStub(CapabilityTransformerInterface::class), self::createStub(CapabilitiesTransformerInterface::class), self::createStub(CapabilityNamespacesTransformerInterface::class), self::createStub(CapabilityPresentationTransformerInterface::class), self::createStub(LocaleReferencesTransformerInterface::class), $localizationTransformer, new Token('test-api-token'), self::createStub(CreateCapabilityRequestSerializerInterface::class), self::createStub(UpdateCapabilityRequestSerializerInterface::class), self::createStub(CapabilityLocalizationRequestSerializerInterface::class), self::createStub(CreateCapabilityPresentationRequestSerializerInterface::class), self::createStub(UpdateCapabilityPresentationRequestSerializerInterface::class), new RequestUrlBuilder());
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
