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
use ChristianBrown\SmartThings\Model\PreferenceListQuery;
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
#[CoversClass(PreferenceListQuery::class)]
final class DevicePreferenceDefinitionApiQueryParametersTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleAppliesTheQuery(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [DevicePreferenceDefinitionApiInterface::API_URL, [], $this->headers(), [DevicePreferenceDefinitionApiInterface::KEY_ITEMS => ['plain']]],
                [DevicePreferenceDefinitionApiInterface::API_URL.'?namespace=explicit-namespace&pageSize=10&startKey=test-key', [], $this->headers(), [DevicePreferenceDefinitionApiInterface::KEY_ITEMS => ['variant']]],
            ]);
        $plain = [self::createStub(DevicePreferenceDefinitionInterface::class)];
        $variant = [self::createStub(DevicePreferenceDefinitionInterface::class)];
        $transformer = self::createStub(DevicePreferenceDefinitionsTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $query = (new PreferenceListQuery())->setNamespace('query-namespace')->setPageSize(10)->setStartKey('test-key');
        $api = $this->api($requestSender, devicePreferenceDefinitionsTransformer: $transformer);

        self::assertSame($plain, $api->getMultiple());
        self::assertSame($variant, $api->getMultiple('explicit-namespace', false, $query));
        self::assertSame($plain, $api->getMultiple());
        self::assertSame($variant, $api->getMultiple('explicit-namespace', false, $query));
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
