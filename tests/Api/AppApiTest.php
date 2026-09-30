<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\AppApi;
use ChristianBrown\SmartThings\Api\AppApiInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AppInterface;
use ChristianBrown\SmartThings\Model\AppOauthInterface;
use ChristianBrown\SmartThings\Model\AppSettingsInterface;
use ChristianBrown\SmartThings\Model\CreateAppRequestInterface;
use ChristianBrown\SmartThings\Model\CreateAppResponseInterface;
use ChristianBrown\SmartThings\Model\GenerateAppOauthRequestInterface;
use ChristianBrown\SmartThings\Model\GenerateAppOauthResponseInterface;
use ChristianBrown\SmartThings\Model\UpdateAppOauthRequestInterface;
use ChristianBrown\SmartThings\Model\UpdateAppRequestInterface;
use ChristianBrown\SmartThings\Model\UpdateAppSettingsRequestInterface;
use ChristianBrown\SmartThings\Model\UpdateSignatureTypeRequestInterface;
use ChristianBrown\SmartThings\Serializer\CreateAppRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\GenerateAppOauthRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateAppOauthRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateAppRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateAppSettingsRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateSignatureTypeRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\AppOauthTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppSettingsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CreateAppResponseTransformerInterface;
use ChristianBrown\SmartThings\Transformer\GenerateAppOauthResponseTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(AppApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
final class AppApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateApp(): void
    {
        $data = ['test-data'];

        $request = self::createStub(CreateAppRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                AppApiInterface::API_URL,
                [AppApiInterface::KEY_SIGNATURE_TYPE => 'test-signature-type', AppApiInterface::KEY_REQUIRE_CONFIRMATION => 'true', AppApiInterface::KEY_ACCOUNT_ID => 'test-account-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(CreateAppRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(CreateAppResponseInterface::class);

        $transformer = self::createMock(CreateAppResponseTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), $serializer, $transformer, self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());
        $actual = $api->createApp($request, 'test-signature-type', true, 'test-account-id');

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateAppInvalidatesListCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn([AppApiInterface::KEY_ITEMS => ['test-item']]);
        $requestSender->expects(self::once())->method('post')
            ->willReturn(['test-data']);

        $api = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

        $api->getMultiple();
        $api->createApp(self::createStub(CreateAppRequestInterface::class));
        $api->getMultiple();

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateAppUnexpectedResponse(): void
    {
        $request = self::createStub(CreateAppRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $api = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(AppApiInterface::UNEXPECTED_RESPONSE);
        $api->createApp($request);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateAppWithoutOptionalParameters(): void
    {
        $data = ['test-data'];

        $request = self::createStub(CreateAppRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                AppApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(CreateAppRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(CreateAppResponseInterface::class);

        $transformer = self::createMock(CreateAppResponseTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), $serializer, $transformer, self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());
        $actual = $api->createApp($request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteApp(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(
                sprintf(AppApiInterface::API_URL_SPRINTF, 'test-app-name-or-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $api = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());
        $api->deleteApp('test-app-name-or-id');

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteAppInvalidatesCaches(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn(['test-data']);
        $requestSender->expects(self::once())->method('delete')
            ->willReturn([]);

        $api = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

        $api->getOneById('test-app-name-or-id');
        $api->deleteApp('test-app-name-or-id');
        $api->getOneById('test-app-name-or-id');

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGenerateAppOauth(): void
    {
        $data = ['test-data'];

        $request = self::createStub(GenerateAppOauthRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                sprintf(AppApiInterface::API_URL_OAUTH_GENERATE_SPRINTF, 'test-app-name-or-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(GenerateAppOauthRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(GenerateAppOauthResponseInterface::class);

        $transformer = self::createMock(GenerateAppOauthResponseTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), $serializer, $transformer, self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());
        $actual = $api->generateAppOauth('test-app-name-or-id', $request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGenerateAppOauthUnexpectedResponse(): void
    {
        $request = self::createStub(GenerateAppOauthRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $api = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(AppApiInterface::UNEXPECTED_RESPONSE);
        $api->generateAppOauth('test-app-name-or-id', $request);
    }

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

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), $appsTransformer, self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());
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

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), $appsTransformer, self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

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

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), $appsTransformer, self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

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

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

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

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), $appOauthTransformer, self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());
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

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), $appOauthTransformer, self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

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

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), $appOauthTransformer, self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

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

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

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

        $appApi = new AppApi($requestSender, $appTransformer, self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());
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

        $appApi = new AppApi($requestSender, $appTransformer, self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

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

        $appApi = new AppApi($requestSender, $appTransformer, self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());
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

        $appApi = new AppApi($requestSender, $appTransformer, self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

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

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

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

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), $appSettingsTransformer, new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());
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

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), $appSettingsTransformer, new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

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

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), $appSettingsTransformer, new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

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

        $appApi = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(AppApiInterface::UNEXPECTED_RESPONSE);
        $appApi->getSettings('test-app-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testRegister(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(AppApiInterface::API_URL_REGISTER_SPRINTF, 'test-app-name-or-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $api = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());
        $api->register('test-app-name-or-id');

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateApp(): void
    {
        $data = ['test-data'];

        $request = self::createStub(UpdateAppRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(AppApiInterface::API_URL_SPRINTF, 'test-app-name-or-id'),
                [AppApiInterface::KEY_SIGNATURE_TYPE => 'test-signature-type', AppApiInterface::KEY_REQUIRE_CONFIRMATION => 'true'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(UpdateAppRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(AppInterface::class);

        $transformer = self::createMock(AppTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new AppApi($requestSender, $transformer, self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), $serializer, self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());
        $actual = $api->updateApp('test-app-name-or-id', $request, 'test-signature-type', true);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateAppOauth(): void
    {
        $data = ['test-data'];

        $request = self::createStub(UpdateAppOauthRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(AppApiInterface::API_URL_OAUTH_SPRINTF, 'test-app-name-or-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(UpdateAppOauthRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(AppOauthInterface::class);

        $transformer = self::createMock(AppOauthTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), $transformer, self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), $serializer, self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());
        $actual = $api->updateAppOauth('test-app-name-or-id', $request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateAppOauthUnexpectedResponse(): void
    {
        $request = self::createStub(UpdateAppOauthRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn([]);

        $api = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(AppApiInterface::UNEXPECTED_RESPONSE);
        $api->updateAppOauth('test-app-name-or-id', $request);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateAppRefreshesCaches(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(1))->method('get')
            ->willReturn(['test-data']);
        $requestSender->expects(self::once())->method('put')
            ->willReturn(['test-data']);

        $api = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

        $api->getOneById('test-app-name-or-id');
        $api->updateApp('test-app-name-or-id', self::createStub(UpdateAppRequestInterface::class));
        $api->getOneById('test-app-name-or-id');

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateAppSettings(): void
    {
        $data = ['test-data'];

        $request = self::createStub(UpdateAppSettingsRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(AppApiInterface::API_URL_SETTINGS_SPRINTF, 'test-app-name-or-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(UpdateAppSettingsRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(AppSettingsInterface::class);

        $transformer = self::createMock(AppSettingsTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), $transformer, new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), $serializer, self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());
        $actual = $api->updateAppSettings('test-app-name-or-id', $request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateAppSettingsUnexpectedResponse(): void
    {
        $request = self::createStub(UpdateAppSettingsRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn([]);

        $api = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(AppApiInterface::UNEXPECTED_RESPONSE);
        $api->updateAppSettings('test-app-name-or-id', $request);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateAppUnexpectedResponse(): void
    {
        $request = self::createStub(UpdateAppRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn([]);

        $api = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(AppApiInterface::UNEXPECTED_RESPONSE);
        $api->updateApp('test-app-name-or-id', $request);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateAppWithoutOptionalParameters(): void
    {
        $data = ['test-data'];

        $request = self::createStub(UpdateAppRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(AppApiInterface::API_URL_SPRINTF, 'test-app-name-or-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(UpdateAppRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(AppInterface::class);

        $transformer = self::createMock(AppTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new AppApi($requestSender, $transformer, self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), $serializer, self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), self::createStub(UpdateSignatureTypeRequestSerializerInterface::class), new RequestUrlBuilder());
        $actual = $api->updateApp('test-app-name-or-id', $request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateSignatureType(): void
    {
        $request = self::createStub(UpdateSignatureTypeRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(AppApiInterface::API_URL_SIGNATURE_TYPE_SPRINTF, 'test-app-name-or-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn([]);

        $serializer = self::createMock(UpdateSignatureTypeRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $api = new AppApi($requestSender, self::createStub(AppTransformerInterface::class), self::createStub(AppsTransformerInterface::class), self::createStub(AppOauthTransformerInterface::class), self::createStub(AppSettingsTransformerInterface::class), new Token('test-api-token'), self::createStub(CreateAppRequestSerializerInterface::class), self::createStub(CreateAppResponseTransformerInterface::class), self::createStub(UpdateAppRequestSerializerInterface::class), self::createStub(UpdateAppSettingsRequestSerializerInterface::class), self::createStub(UpdateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthRequestSerializerInterface::class), self::createStub(GenerateAppOauthResponseTransformerInterface::class), $serializer, new RequestUrlBuilder());
        $api->updateSignatureType('test-app-name-or-id', $request);

        $this->addToAssertionCount(1);
    }
}
