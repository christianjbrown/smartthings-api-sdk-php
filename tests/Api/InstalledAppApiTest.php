<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\InstalledAppApi;
use ChristianBrown\SmartThings\Api\InstalledAppApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledAppConfigInterface;
use ChristianBrown\SmartThings\Model\InstalledAppInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;

use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(InstalledAppApi::class)]
#[CoversClass(Token::class)]
final class InstalledAppApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetConfig(): void
    {
        $data = ['test-config-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(InstalledAppApiInterface::API_URL_CONFIG_SPRINTF, 'test-installed-app-id', 'test-config-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $config = self::createStub(InstalledAppConfigInterface::class);

        $configTransformer = self::createMock(InstalledAppConfigTransformerInterface::class);
        $configTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($config);

        $api = new InstalledAppApi($requestSender, self::createStub(InstalledAppTransformerInterface::class), self::createStub(InstalledAppsTransformerInterface::class), $configTransformer, self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));
        $actual = $api->getConfig('test-installed-app-id', 'test-config-id');

        self::assertSame($config, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetConfigCaches(): void
    {
        $data = ['test-config-data'];

        $config = self::createStub(InstalledAppConfigInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $configTransformer = self::createMock(InstalledAppConfigTransformerInterface::class);
        $configTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($config);

        $api = new InstalledAppApi($requestSender, self::createStub(InstalledAppTransformerInterface::class), self::createStub(InstalledAppsTransformerInterface::class), $configTransformer, self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));

        // Second call for the same ids is served from the cache without hitting the API.
        self::assertSame($config, $api->getConfig('test-installed-app-id', 'test-config-id'));
        self::assertSame($config, $api->getConfig('test-installed-app-id', 'test-config-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c', 'x/y z'])]
    #[TestWith(['../../installedapps', '../../configs'])]
    public function testGetConfigEncodesIds(string $installedAppId, string $configurationId): void
    {
        $data = ['test-config-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(InstalledAppApiInterface::API_URL_CONFIG_SPRINTF, rawurlencode($installedAppId), rawurlencode($configurationId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $config = self::createStub(InstalledAppConfigInterface::class);

        $configTransformer = self::createMock(InstalledAppConfigTransformerInterface::class);
        $configTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($config);

        $api = new InstalledAppApi($requestSender, self::createStub(InstalledAppTransformerInterface::class), self::createStub(InstalledAppsTransformerInterface::class), $configTransformer, self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));
        $actual = $api->getConfig($installedAppId, $configurationId);

        self::assertSame($config, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetConfigs(): void
    {
        $data = [
            InstalledAppApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(InstalledAppApiInterface::API_URL_CONFIGS_SPRINTF, 'test-installed-app-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $configs = [self::createStub(InstalledAppConfigInterface::class)];

        $configsTransformer = self::createMock(InstalledAppConfigsTransformerInterface::class);
        $configsTransformer->expects(self::once())->method('transform')
            ->with($data[InstalledAppApiInterface::KEY_ITEMS])
            ->willReturn($configs);

        $api = new InstalledAppApi($requestSender, self::createStub(InstalledAppTransformerInterface::class), self::createStub(InstalledAppsTransformerInterface::class), self::createStub(InstalledAppConfigTransformerInterface::class), $configsTransformer, new Token('test-api-token'));
        $actual = $api->getConfigs('test-installed-app-id');

        self::assertSame($configs, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetConfigsCaches(): void
    {
        $data = [
            InstalledAppApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $configs = [self::createStub(InstalledAppConfigInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $configsTransformer = self::createMock(InstalledAppConfigsTransformerInterface::class);
        $configsTransformer->expects(self::once())
            ->method('transform')
            ->with($data[InstalledAppApiInterface::KEY_ITEMS])
            ->willReturn($configs);

        $api = new InstalledAppApi($requestSender, self::createStub(InstalledAppTransformerInterface::class), self::createStub(InstalledAppsTransformerInterface::class), self::createStub(InstalledAppConfigTransformerInterface::class), $configsTransformer, new Token('test-api-token'));

        // Second call for the same installed app is served from the cache without hitting the API.
        self::assertSame($configs, $api->getConfigs('test-installed-app-id'));
        self::assertSame($configs, $api->getConfigs('test-installed-app-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetConfigSkipsCache(): void
    {
        $data = ['test-config-data'];

        $config = self::createStub(InstalledAppConfigInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $configTransformer = self::createMock(InstalledAppConfigTransformerInterface::class);
        $configTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($config);

        $api = new InstalledAppApi($requestSender, self::createStub(InstalledAppTransformerInterface::class), self::createStub(InstalledAppsTransformerInterface::class), $configTransformer, self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($config, $api->getConfig('test-installed-app-id', 'test-config-id'));
        self::assertSame($config, $api->getConfig('test-installed-app-id', 'test-config-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetConfigsSkipsCache(): void
    {
        $data = [
            InstalledAppApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $configs = [self::createStub(InstalledAppConfigInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $configsTransformer = self::createMock(InstalledAppConfigsTransformerInterface::class);
        $configsTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[InstalledAppApiInterface::KEY_ITEMS])
            ->willReturn($configs);

        $api = new InstalledAppApi($requestSender, self::createStub(InstalledAppTransformerInterface::class), self::createStub(InstalledAppsTransformerInterface::class), self::createStub(InstalledAppConfigTransformerInterface::class), $configsTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($configs, $api->getConfigs('test-installed-app-id'));
        self::assertSame($configs, $api->getConfigs('test-installed-app-id', true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[InstalledAppApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[InstalledAppApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetConfigsUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn($data);

        $api = new InstalledAppApi($requestSender, self::createStub(InstalledAppTransformerInterface::class), self::createStub(InstalledAppsTransformerInterface::class), self::createStub(InstalledAppConfigTransformerInterface::class), self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(InstalledAppApiInterface::UNEXPECTED_RESPONSE_SPRINTF, InstalledAppApiInterface::KEY_ITEMS));
        $api->getConfigs('test-installed-app-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetConfigUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn([]);

        $api = new InstalledAppApi($requestSender, self::createStub(InstalledAppTransformerInterface::class), self::createStub(InstalledAppsTransformerInterface::class), self::createStub(InstalledAppConfigTransformerInterface::class), self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(InstalledAppApiInterface::UNEXPECTED_RESPONSE);
        $api->getConfig('test-installed-app-id', 'test-config-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMe(): void
    {
        $data = ['test-installed-app-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                InstalledAppApiInterface::API_URL_ME,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $installedApp = self::createStub(InstalledAppInterface::class);

        $installedAppTransformer = self::createMock(InstalledAppTransformerInterface::class);
        $installedAppTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($installedApp);

        $api = new InstalledAppApi($requestSender, $installedAppTransformer, self::createStub(InstalledAppsTransformerInterface::class), self::createStub(InstalledAppConfigTransformerInterface::class), self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));
        $actual = $api->getMe();

        self::assertSame($installedApp, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMeCaches(): void
    {
        $data = ['test-installed-app-data'];

        $installedApp = self::createStub(InstalledAppInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $installedAppTransformer = self::createMock(InstalledAppTransformerInterface::class);
        $installedAppTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($installedApp);

        $api = new InstalledAppApi($requestSender, $installedAppTransformer, self::createStub(InstalledAppsTransformerInterface::class), self::createStub(InstalledAppConfigTransformerInterface::class), self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));

        // Second call is served from the cache without hitting the API.
        self::assertSame($installedApp, $api->getMe());
        self::assertSame($installedApp, $api->getMe());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMeSkipsCache(): void
    {
        $data = ['test-installed-app-data'];

        $installedApp = self::createStub(InstalledAppInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $installedAppTransformer = self::createMock(InstalledAppTransformerInterface::class);
        $installedAppTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($installedApp);

        $api = new InstalledAppApi($requestSender, $installedAppTransformer, self::createStub(InstalledAppsTransformerInterface::class), self::createStub(InstalledAppConfigTransformerInterface::class), self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($installedApp, $api->getMe());
        self::assertSame($installedApp, $api->getMe(true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetMeUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn([]);

        $api = new InstalledAppApi($requestSender, self::createStub(InstalledAppTransformerInterface::class), self::createStub(InstalledAppsTransformerInterface::class), self::createStub(InstalledAppConfigTransformerInterface::class), self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(InstalledAppApiInterface::UNEXPECTED_RESPONSE);
        $api->getMe($skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            InstalledAppApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                InstalledAppApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $installedApps = [self::createStub(InstalledAppInterface::class), self::createStub(InstalledAppInterface::class)];

        $installedAppsTransformer = self::createMock(InstalledAppsTransformerInterface::class);
        $installedAppsTransformer->expects(self::once())->method('transform')
            ->with($data[InstalledAppApiInterface::KEY_ITEMS])
            ->willReturn($installedApps);

        $api = new InstalledAppApi($requestSender, self::createStub(InstalledAppTransformerInterface::class), $installedAppsTransformer, self::createStub(InstalledAppConfigTransformerInterface::class), self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));
        $actual = $api->getMultiple();

        self::assertSame($installedApps, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            InstalledAppApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $installedApps = [self::createStub(InstalledAppInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $installedAppsTransformer = self::createMock(InstalledAppsTransformerInterface::class);
        $installedAppsTransformer->expects(self::once())
            ->method('transform')
            ->with($data[InstalledAppApiInterface::KEY_ITEMS])
            ->willReturn($installedApps);

        $api = new InstalledAppApi($requestSender, self::createStub(InstalledAppTransformerInterface::class), $installedAppsTransformer, self::createStub(InstalledAppConfigTransformerInterface::class), self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));

        // Second call with the same filter is served from the cache without hitting the API.
        self::assertSame($installedApps, $api->getMultiple());
        self::assertSame($installedApps, $api->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleFiltersByLocation(): void
    {
        $data = [
            InstalledAppApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                InstalledAppApiInterface::API_URL,
                [InstalledAppApiInterface::KEY_LOCATION_ID => 'test-location-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $installedApps = [self::createStub(InstalledAppInterface::class)];

        $installedAppsTransformer = self::createMock(InstalledAppsTransformerInterface::class);
        $installedAppsTransformer->expects(self::once())->method('transform')
            ->with($data[InstalledAppApiInterface::KEY_ITEMS])
            ->willReturn($installedApps);

        $api = new InstalledAppApi($requestSender, self::createStub(InstalledAppTransformerInterface::class), $installedAppsTransformer, self::createStub(InstalledAppConfigTransformerInterface::class), self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));
        $actual = $api->getMultiple('test-location-id');

        self::assertSame($installedApps, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            InstalledAppApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $installedApps = [self::createStub(InstalledAppInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $installedAppsTransformer = self::createMock(InstalledAppsTransformerInterface::class);
        $installedAppsTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[InstalledAppApiInterface::KEY_ITEMS])
            ->willReturn($installedApps);

        $api = new InstalledAppApi($requestSender, self::createStub(InstalledAppTransformerInterface::class), $installedAppsTransformer, self::createStub(InstalledAppConfigTransformerInterface::class), self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($installedApps, $api->getMultiple());
        self::assertSame($installedApps, $api->getMultiple(null, true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[InstalledAppApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[InstalledAppApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                InstalledAppApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $api = new InstalledAppApi($requestSender, self::createStub(InstalledAppTransformerInterface::class), self::createStub(InstalledAppsTransformerInterface::class), self::createStub(InstalledAppConfigTransformerInterface::class), self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(InstalledAppApiInterface::UNEXPECTED_RESPONSE_SPRINTF, InstalledAppApiInterface::KEY_ITEMS));
        $api->getMultiple(null, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-installed-app-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(InstalledAppApiInterface::API_URL_SPRINTF, 'test-installed-app-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $installedApp = self::createStub(InstalledAppInterface::class);

        $installedAppTransformer = self::createMock(InstalledAppTransformerInterface::class);
        $installedAppTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($installedApp);

        $api = new InstalledAppApi($requestSender, $installedAppTransformer, self::createStub(InstalledAppsTransformerInterface::class), self::createStub(InstalledAppConfigTransformerInterface::class), self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));
        $actual = $api->getOneById('test-installed-app-id');

        self::assertSame($installedApp, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $data = ['test-installed-app-data'];

        $installedApp = self::createStub(InstalledAppInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $installedAppTransformer = self::createMock(InstalledAppTransformerInterface::class);
        $installedAppTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($installedApp);

        $api = new InstalledAppApi($requestSender, $installedAppTransformer, self::createStub(InstalledAppsTransformerInterface::class), self::createStub(InstalledAppConfigTransformerInterface::class), self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));

        // Second call for the same installed app is served from the cache without hitting the API.
        self::assertSame($installedApp, $api->getOneById('test-installed-app-id'));
        self::assertSame($installedApp, $api->getOneById('test-installed-app-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../installedapps'])]
    public function testGetOneByIdEncodesId(string $installedAppId): void
    {
        $data = ['test-installed-app-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(InstalledAppApiInterface::API_URL_SPRINTF, rawurlencode($installedAppId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $installedApp = self::createStub(InstalledAppInterface::class);

        $installedAppTransformer = self::createMock(InstalledAppTransformerInterface::class);
        $installedAppTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($installedApp);

        $api = new InstalledAppApi($requestSender, $installedAppTransformer, self::createStub(InstalledAppsTransformerInterface::class), self::createStub(InstalledAppConfigTransformerInterface::class), self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));
        $actual = $api->getOneById($installedAppId);

        self::assertSame($installedApp, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $data = ['test-installed-app-data'];

        $installedApp = self::createStub(InstalledAppInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $installedAppTransformer = self::createMock(InstalledAppTransformerInterface::class);
        $installedAppTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($installedApp);

        $api = new InstalledAppApi($requestSender, $installedAppTransformer, self::createStub(InstalledAppsTransformerInterface::class), self::createStub(InstalledAppConfigTransformerInterface::class), self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($installedApp, $api->getOneById('test-installed-app-id'));
        self::assertSame($installedApp, $api->getOneById('test-installed-app-id', true));
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

        $api = new InstalledAppApi($requestSender, self::createStub(InstalledAppTransformerInterface::class), self::createStub(InstalledAppsTransformerInterface::class), self::createStub(InstalledAppConfigTransformerInterface::class), self::createStub(InstalledAppConfigsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(InstalledAppApiInterface::UNEXPECTED_RESPONSE);
        $api->getOneById('test-installed-app-id', $skipCache);
    }
}
