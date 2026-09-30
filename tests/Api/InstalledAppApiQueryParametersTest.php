<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\InstalledAppApi;
use ChristianBrown\SmartThings\Api\InstalledAppApiInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Model\InstalledAppConfigInterface;
use ChristianBrown\SmartThings\Model\InstalledAppInterface;
use ChristianBrown\SmartThings\Model\InstalledAppListQuery;
use ChristianBrown\SmartThings\Serializer\CoordinateAliasRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\CreateInstalledAppEventsRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(InstalledAppApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
#[CoversClass(InstalledAppListQuery::class)]
final class InstalledAppApiQueryParametersTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetConfigsSendsConfigurationStatusAndCachesPerVariant(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [sprintf(InstalledAppApiInterface::API_URL_CONFIGS_SPRINTF, 'test-app-id'), [], $this->headers(), [InstalledAppApiInterface::KEY_ITEMS => ['plain']]],
                [sprintf(InstalledAppApiInterface::API_URL_CONFIGS_SPRINTF, 'test-app-id').'?configurationStatus=DONE', [], $this->headers(), [InstalledAppApiInterface::KEY_ITEMS => ['variant']]],
            ]);
        $plain = [self::createStub(InstalledAppConfigInterface::class)];
        $variant = [self::createStub(InstalledAppConfigInterface::class)];
        $transformer = self::createStub(InstalledAppConfigsTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $api = $this->api($requestSender, installedAppConfigsTransformer: $transformer);

        self::assertSame($plain, $api->getConfigs('test-app-id'));
        self::assertSame($variant, $api->getConfigs('test-app-id', false, 'DONE'));
        self::assertSame($plain, $api->getConfigs('test-app-id'));
        self::assertSame($variant, $api->getConfigs('test-app-id', false, 'DONE'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleAppliesTheQuery(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                InstalledAppApiInterface::API_URL.'?appId=test-app&deviceId=test-device&installedAppStatus=AUTHORIZED&installedAppType=LAMBDA_SMART_APP&locationId=test-location&modeId=test-mode&tag=test-tag',
                [],
                $this->headers()
            )
            ->willReturn([InstalledAppApiInterface::KEY_ITEMS => ['test-item']]);
        $installedApps = [self::createStub(InstalledAppInterface::class)];
        $transformer = self::createStub(InstalledAppsTransformerInterface::class);
        $transformer->method('transform')->willReturn($installedApps);

        $query = (new InstalledAppListQuery())->setAppId('test-app')->setDeviceId('test-device')->setInstalledAppStatus('AUTHORIZED')->setInstalledAppType('LAMBDA_SMART_APP')->setModeId('test-mode')->setTag('test-tag');
        $api = $this->api($requestSender, installedAppsTransformer: $transformer);

        self::assertSame($installedApps, $api->getMultiple('test-location', false, $query));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSendsAllowedAndCachesPerVariant(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [sprintf(InstalledAppApiInterface::API_URL_SPRINTF, 'test-app-id'), [], $this->headers(), ['plain']],
                [sprintf(InstalledAppApiInterface::API_URL_SPRINTF, 'test-app-id').'?allowed=true', [], $this->headers(), ['variant']],
            ]);
        $plain = self::createStub(InstalledAppInterface::class);
        $variant = self::createStub(InstalledAppInterface::class);
        $transformer = self::createStub(InstalledAppTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $api = $this->api($requestSender, installedAppTransformer: $transformer);

        self::assertSame($plain, $api->getOneById('test-app-id'));
        self::assertSame($variant, $api->getOneById('test-app-id', false, true));
        self::assertSame($plain, $api->getOneById('test-app-id'));
        self::assertSame($variant, $api->getOneById('test-app-id', false, true));
    }

    private function api(JsonApiRequestSenderInterface $requestSender, ?InstalledAppTransformerInterface $installedAppTransformer = null, ?InstalledAppsTransformerInterface $installedAppsTransformer = null, ?InstalledAppConfigTransformerInterface $installedAppConfigTransformer = null, ?InstalledAppConfigsTransformerInterface $installedAppConfigsTransformer = null, ?CreateInstalledAppEventsRequestSerializerInterface $createInstalledAppEventsRequestSerializer = null, ?CoordinateAliasRequestSerializerInterface $coordinateAliasRequestSerializer = null): InstalledAppApi
    {
        return new InstalledAppApi($requestSender, $installedAppTransformer ?? self::createStub(InstalledAppTransformerInterface::class), $installedAppsTransformer ?? self::createStub(InstalledAppsTransformerInterface::class), $installedAppConfigTransformer ?? self::createStub(InstalledAppConfigTransformerInterface::class), $installedAppConfigsTransformer ?? self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'), $createInstalledAppEventsRequestSerializer ?? self::createStub(CreateInstalledAppEventsRequestSerializerInterface::class), $coordinateAliasRequestSerializer ?? self::createStub(CoordinateAliasRequestSerializerInterface::class), new RequestUrlBuilder());
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
