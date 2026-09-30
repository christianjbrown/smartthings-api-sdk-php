<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\SchemaConnectorApi;
use ChristianBrown\SmartThings\Api\SchemaConnectorApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Model\InstalledSchemaAppInterface;
use ChristianBrown\SmartThings\Serializer\SchemaAppCreateRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SchemaAppUpdateRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\SchemaOauthCredentialsRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppReceiptTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaPageTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(SchemaConnectorApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
final class SchemaConnectorApiQueryParametersTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstalledByIdSendsFlagsAndCachesPerVariant(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [sprintf(SchemaConnectorApiInterface::API_URL_INSTALLED_APP_SPRINTF, 'test-isa-id'), [], $this->headers(), ['plain']],
                [sprintf(SchemaConnectorApiInterface::API_URL_INSTALLED_APP_SPRINTF, 'test-isa-id').'?redirectRequested=true&jsonRspRequested=false', [], $this->headers(), ['variant']],
            ]);
        $plain = self::createStub(InstalledSchemaAppInterface::class);
        $variant = self::createStub(InstalledSchemaAppInterface::class);
        $transformer = self::createStub(InstalledSchemaAppTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $api = $this->api($requestSender, $transformer);

        self::assertSame($plain, $api->getInstalledById('test-isa-id'));
        self::assertSame($variant, $api->getInstalledById('test-isa-id', false, true, false));
        self::assertSame($plain, $api->getInstalledById('test-isa-id'));
        self::assertSame($variant, $api->getInstalledById('test-isa-id', false, true, false));
    }

    private function api(JsonApiRequestSenderInterface $requestSender, InstalledSchemaAppTransformerInterface $installedSchemaAppTransformer): SchemaConnectorApi
    {
        return new SchemaConnectorApi($requestSender, self::createStub(SchemaAppTransformerInterface::class), self::createStub(SchemaAppsTransformerInterface::class), $installedSchemaAppTransformer, self::createStub(InstalledSchemaAppsTransformerInterface::class), self::createStub(SchemaPageTransformerInterface::class), new Token('test-api-token'), self::createStub(SchemaAppCreateRequestSerializerInterface::class), self::createStub(SchemaAppReceiptTransformerInterface::class), self::createStub(SchemaAppUpdateRequestSerializerInterface::class), self::createStub(SchemaOauthCredentialsRequestSerializerInterface::class), new RequestUrlBuilder());
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
