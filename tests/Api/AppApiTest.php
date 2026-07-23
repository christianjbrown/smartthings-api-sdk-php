<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\AppApi;
use ChristianBrown\SmartThings\Api\AppApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AppInterface;
use ChristianBrown\SmartThings\Model\AppOauthInterface;
use ChristianBrown\SmartThings\Model\AppSettingsInterface;
use ChristianBrown\SmartThings\Transformer\AppOauthTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppSettingsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;

use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(AppApi::class)]
#[CoversClass(Token::class)]
final class AppApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            AppApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                AppApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $apps = [self::createStub(AppInterface::class), self::createStub(AppInterface::class)];

        $appsTransformer = self::createMock(AppsTransformerInterface::class);
        $appsTransformer->expects(self::once())->method('transform')
            ->with($data[AppApiInterface::KEY_ITEMS])
            ->willReturn($apps);

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), $appsTransformer, self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'));
        $actual = $appApi->getMultiple();

        self::assertSame($apps, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            AppApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $apps = [self::createStub(AppInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $appsTransformer = self::createMock(AppsTransformerInterface::class);
        $appsTransformer->expects(self::once())
            ->method('transform')
            ->with($data[AppApiInterface::KEY_ITEMS])
            ->willReturn($apps);

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), $appsTransformer, self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'));

        // Second call is served from the cache without hitting the API.
        self::assertSame($apps, $appApi->getMultiple());
        self::assertSame($apps, $appApi->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            AppApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $apps = [self::createStub(AppInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $appsTransformer = self::createMock(AppsTransformerInterface::class);
        $appsTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[AppApiInterface::KEY_ITEMS])
            ->willReturn($apps);

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), $appsTransformer, self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($apps, $appApi->getMultiple());
        self::assertSame($apps, $appApi->getMultiple(true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[AppApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[AppApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                AppApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(AppApiInterface::UNEXPECTED_RESPONSE_SPRINTF, AppApiInterface::KEY_ITEMS));
        $appApi->getMultiple($skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOauth(): void
    {
        $data = ['test-oauth-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(AppApiInterface::API_URL_OAUTH_SPRINTF, 'test-app-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $oauth = self::createStub(AppOauthInterface::class);

        $appOauthTransformer = self::createMock(AppOauthTransformerInterface::class);
        $appOauthTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($oauth);

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), $appOauthTransformer, self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'));
        $actual = $appApi->getOauth('test-app-id');

        self::assertSame($oauth, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOauthCaches(): void
    {
        $data = ['test-oauth-data'];

        $oauth = self::createStub(AppOauthInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $appOauthTransformer = self::createMock(AppOauthTransformerInterface::class);
        $appOauthTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($oauth);

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), $appOauthTransformer, self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'));

        // Second call for the same app is served from the cache without hitting the API.
        self::assertSame($oauth, $appApi->getOauth('test-app-id'));
        self::assertSame($oauth, $appApi->getOauth('test-app-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOauthSkipsCache(): void
    {
        $data = ['test-oauth-data'];

        $oauth = self::createStub(AppOauthInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $appOauthTransformer = self::createMock(AppOauthTransformerInterface::class);
        $appOauthTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($oauth);

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), $appOauthTransformer, self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($oauth, $appApi->getOauth('test-app-id'));
        self::assertSame($oauth, $appApi->getOauth('test-app-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetOauthUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn([]);

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(AppApiInterface::UNEXPECTED_RESPONSE);
        $appApi->getOauth('test-app-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-app-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(AppApiInterface::API_URL_SPRINTF, 'test-app-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $app = self::createStub(AppInterface::class);

        $appTransformer = self::createMock(AppTransformerInterface::class);
        $appTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($app);

        $appApi = new AppApi($requestSender, $appTransformer, self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'));
        $actual = $appApi->getOneById('test-app-id');

        self::assertSame($app, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $data = ['test-app-data'];

        $app = self::createStub(AppInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $appTransformer = self::createMock(AppTransformerInterface::class);
        $appTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($app);

        $appApi = new AppApi($requestSender, $appTransformer, self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'));

        // Second call for the same app is served from the cache without hitting the API.
        self::assertSame($app, $appApi->getOneById('test-app-id'));
        self::assertSame($app, $appApi->getOneById('test-app-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../apps'])]
    public function testGetOneByIdEncodesId(string $appNameOrId): void
    {
        $data = ['test-app-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(AppApiInterface::API_URL_SPRINTF, rawurlencode($appNameOrId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $app = self::createStub(AppInterface::class);

        $appTransformer = self::createMock(AppTransformerInterface::class);
        $appTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($app);

        $appApi = new AppApi($requestSender, $appTransformer, self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'));
        $actual = $appApi->getOneById($appNameOrId);

        self::assertSame($app, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $data = ['test-app-data'];

        $app = self::createStub(AppInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $appTransformer = self::createMock(AppTransformerInterface::class);
        $appTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($app);

        $appApi = new AppApi($requestSender, $appTransformer, self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($app, $appApi->getOneById('test-app-id'));
        self::assertSame($app, $appApi->getOneById('test-app-id', true));
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

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(AppApiInterface::UNEXPECTED_RESPONSE);
        $appApi->getOneById('test-app-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetSettings(): void
    {
        $data = ['test-settings-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(AppApiInterface::API_URL_SETTINGS_SPRINTF, 'test-app-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $settings = self::createStub(AppSettingsInterface::class);

        $appSettingsTransformer = self::createMock(AppSettingsTransformerInterface::class);
        $appSettingsTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($settings);

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), $appSettingsTransformer, new Token('test-api-token'));
        $actual = $appApi->getSettings('test-app-id');

        self::assertSame($settings, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetSettingsCaches(): void
    {
        $data = ['test-settings-data'];

        $settings = self::createStub(AppSettingsInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $appSettingsTransformer = self::createMock(AppSettingsTransformerInterface::class);
        $appSettingsTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($settings);

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), $appSettingsTransformer, new Token('test-api-token'));

        // Second call for the same app is served from the cache without hitting the API.
        self::assertSame($settings, $appApi->getSettings('test-app-id'));
        self::assertSame($settings, $appApi->getSettings('test-app-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetSettingsSkipsCache(): void
    {
        $data = ['test-settings-data'];

        $settings = self::createStub(AppSettingsInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $appSettingsTransformer = self::createMock(AppSettingsTransformerInterface::class);
        $appSettingsTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($settings);

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), $appSettingsTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($settings, $appApi->getSettings('test-app-id'));
        self::assertSame($settings, $appApi->getSettings('test-app-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetSettingsUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn([]);

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(AppApiInterface::UNEXPECTED_RESPONSE);
        $appApi->getSettings('test-app-id', $skipCache);
    }
}
