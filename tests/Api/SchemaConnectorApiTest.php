<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\SchemaConnectorApi;
use ChristianBrown\SmartThings\Api\SchemaConnectorApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledSchemaAppInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInterface;
use ChristianBrown\SmartThings\Model\SchemaPageInterface;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledSchemaAppTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaPageTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(SchemaConnectorApi::class)]
#[CoversClass(Token::class)]
final class SchemaConnectorApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstalledById(): void
    {
        $data = ['test-installed-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(SchemaConnectorApiInterface::API_URL_INSTALLED_APP_SPRINTF, 'test-isa-id'),
                [],
                self::authHeaders()
            )
            ->willReturn($data);

        $app = self::createStub(InstalledSchemaAppInterface::class);

        $installedTransformer = self::createMock(InstalledSchemaAppTransformerInterface::class);
        $installedTransformer->expects(self::once())->method('transform')->with($data)->willReturn($app);

        $api = self::createApi($requestSender, installedTransformer: $installedTransformer);

        self::assertSame($app, $api->getInstalledById('test-isa-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstalledByIdCaches(): void
    {
        $app = self::createStub(InstalledSchemaAppInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-installed-data']);

        $installedTransformer = self::createMock(InstalledSchemaAppTransformerInterface::class);
        $installedTransformer->expects(self::once())->method('transform')->willReturn($app);

        $api = self::createApi($requestSender, installedTransformer: $installedTransformer);

        // Second call for the same id is served from the cache without hitting the API.
        self::assertSame($app, $api->getInstalledById('test-isa-id'));
        self::assertSame($app, $api->getInstalledById('test-isa-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../installedapps'])]
    public function testGetInstalledByIdEncodesId(string $isaId): void
    {
        $data = ['test-installed-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(SchemaConnectorApiInterface::API_URL_INSTALLED_APP_SPRINTF, rawurlencode($isaId)),
                [],
                self::authHeaders()
            )
            ->willReturn($data);

        $app = self::createStub(InstalledSchemaAppInterface::class);

        $installedTransformer = self::createMock(InstalledSchemaAppTransformerInterface::class);
        $installedTransformer->expects(self::once())->method('transform')->with($data)->willReturn($app);

        $api = self::createApi($requestSender, installedTransformer: $installedTransformer);

        self::assertSame($app, $api->getInstalledById($isaId));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstalledByIdSkipsCache(): void
    {
        $app = self::createStub(InstalledSchemaAppInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-installed-data']);

        $installedTransformer = self::createMock(InstalledSchemaAppTransformerInterface::class);
        $installedTransformer->expects(self::exactly(2))->method('transform')->willReturn($app);

        $api = self::createApi($requestSender, installedTransformer: $installedTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($app, $api->getInstalledById('test-isa-id'));
        self::assertSame($app, $api->getInstalledById('test-isa-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetInstalledByIdUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = self::createApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(SchemaConnectorApiInterface::UNEXPECTED_RESPONSE);
        $api->getInstalledById('test-isa-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstalledMultiple(): void
    {
        $data = [
            SchemaConnectorApiInterface::KEY_INSTALLED_SMART_APPS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(SchemaConnectorApiInterface::API_URL_INSTALLED_APPS_LOCATION_SPRINTF, 'test-location-id'),
                [],
                self::authHeaders()
            )
            ->willReturn($data);

        $apps = [self::createStub(InstalledSchemaAppInterface::class)];

        $installedsTransformer = self::createMock(InstalledSchemaAppsTransformerInterface::class);
        $installedsTransformer->expects(self::once())->method('transform')
            ->with($data[SchemaConnectorApiInterface::KEY_INSTALLED_SMART_APPS])
            ->willReturn($apps);

        $api = self::createApi($requestSender, installedsTransformer: $installedsTransformer);

        self::assertSame($apps, $api->getInstalledMultiple('test-location-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstalledMultipleCaches(): void
    {
        $apps = [self::createStub(InstalledSchemaAppInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([SchemaConnectorApiInterface::KEY_INSTALLED_SMART_APPS => ['test-item-1']]);

        $installedsTransformer = self::createMock(InstalledSchemaAppsTransformerInterface::class);
        $installedsTransformer->expects(self::once())->method('transform')->willReturn($apps);

        $api = self::createApi($requestSender, installedsTransformer: $installedsTransformer);

        // Second call for the same location is served from the cache without hitting the API.
        self::assertSame($apps, $api->getInstalledMultiple('test-location-id'));
        self::assertSame($apps, $api->getInstalledMultiple('test-location-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstalledMultipleSkipsCache(): void
    {
        $apps = [self::createStub(InstalledSchemaAppInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn([SchemaConnectorApiInterface::KEY_INSTALLED_SMART_APPS => ['test-item-1']]);

        $installedsTransformer = self::createMock(InstalledSchemaAppsTransformerInterface::class);
        $installedsTransformer->expects(self::exactly(2))->method('transform')->willReturn($apps);

        $api = self::createApi($requestSender, installedsTransformer: $installedsTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($apps, $api->getInstalledMultiple('test-location-id'));
        self::assertSame($apps, $api->getInstalledMultiple('test-location-id', true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-key-missing'], false])]
    #[TestWith([[SchemaConnectorApiInterface::KEY_INSTALLED_SMART_APPS => 'test-not-array'], false])]
    #[TestWith([['test-key-missing'], true])]
    #[TestWith([[SchemaConnectorApiInterface::KEY_INSTALLED_SMART_APPS => 'test-not-array'], true])]
    public function testGetInstalledMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn($data);

        $api = self::createApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SchemaConnectorApiInterface::UNEXPECTED_RESPONSE_SPRINTF, SchemaConnectorApiInterface::KEY_INSTALLED_SMART_APPS));
        $api->getInstalledMultiple('test-location-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstallPage(): void
    {
        $data = ['test-page-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(SchemaConnectorApiInterface::API_URL_INSTALL_SPRINTF, 'test-endpoint-app-id'),
                [
                    SchemaConnectorApiInterface::KEY_LOCATION_ID => 'test-location-id',
                    SchemaConnectorApiInterface::KEY_TYPE => SchemaConnectorApiInterface::TYPE_OAUTH_LINK,
                ],
                self::authHeaders()
            )
            ->willReturn($data);

        $page = self::createStub(SchemaPageInterface::class);

        $pageTransformer = self::createMock(SchemaPageTransformerInterface::class);
        $pageTransformer->expects(self::once())->method('transform')->with($data)->willReturn($page);

        $api = self::createApi($requestSender, pageTransformer: $pageTransformer);

        self::assertSame($page, $api->getInstallPage('test-endpoint-app-id', 'test-location-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstallPageCaches(): void
    {
        $page = self::createStub(SchemaPageInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-page-data']);

        $pageTransformer = self::createMock(SchemaPageTransformerInterface::class);
        $pageTransformer->expects(self::once())->method('transform')->willReturn($page);

        $api = self::createApi($requestSender, pageTransformer: $pageTransformer);

        // Second call for the same app and location is served from the cache without hitting the API.
        self::assertSame($page, $api->getInstallPage('test-endpoint-app-id', 'test-location-id'));
        self::assertSame($page, $api->getInstallPage('test-endpoint-app-id', 'test-location-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInstallPageSkipsCache(): void
    {
        $page = self::createStub(SchemaPageInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-page-data']);

        $pageTransformer = self::createMock(SchemaPageTransformerInterface::class);
        $pageTransformer->expects(self::exactly(2))->method('transform')->willReturn($page);

        $api = self::createApi($requestSender, pageTransformer: $pageTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($page, $api->getInstallPage('test-endpoint-app-id', 'test-location-id'));
        self::assertSame($page, $api->getInstallPage('test-endpoint-app-id', 'test-location-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetInstallPageUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = self::createApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(SchemaConnectorApiInterface::UNEXPECTED_RESPONSE);
        $api->getInstallPage('test-endpoint-app-id', 'test-location-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            SchemaConnectorApiInterface::KEY_ENDPOINT_APPS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(SchemaConnectorApiInterface::API_URL_APPS, [], self::authHeaders())
            ->willReturn($data);

        $apps = [self::createStub(SchemaAppInterface::class), self::createStub(SchemaAppInterface::class)];

        $appsTransformer = self::createMock(SchemaAppsTransformerInterface::class);
        $appsTransformer->expects(self::once())->method('transform')
            ->with($data[SchemaConnectorApiInterface::KEY_ENDPOINT_APPS])
            ->willReturn($apps);

        $api = self::createApi($requestSender, appsTransformer: $appsTransformer);

        self::assertSame($apps, $api->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $apps = [self::createStub(SchemaAppInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([SchemaConnectorApiInterface::KEY_ENDPOINT_APPS => ['test-item-1']]);

        $appsTransformer = self::createMock(SchemaAppsTransformerInterface::class);
        $appsTransformer->expects(self::once())->method('transform')->willReturn($apps);

        $api = self::createApi($requestSender, appsTransformer: $appsTransformer);

        // Second call is served from the cache without hitting the API.
        self::assertSame($apps, $api->getMultiple());
        self::assertSame($apps, $api->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $apps = [self::createStub(SchemaAppInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn([SchemaConnectorApiInterface::KEY_ENDPOINT_APPS => ['test-item-1']]);

        $appsTransformer = self::createMock(SchemaAppsTransformerInterface::class);
        $appsTransformer->expects(self::exactly(2))->method('transform')->willReturn($apps);

        $api = self::createApi($requestSender, appsTransformer: $appsTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($apps, $api->getMultiple());
        self::assertSame($apps, $api->getMultiple(true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-key-missing'], false])]
    #[TestWith([[SchemaConnectorApiInterface::KEY_ENDPOINT_APPS => 'test-not-array'], false])]
    #[TestWith([['test-key-missing'], true])]
    #[TestWith([[SchemaConnectorApiInterface::KEY_ENDPOINT_APPS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn($data);

        $api = self::createApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SchemaConnectorApiInterface::UNEXPECTED_RESPONSE_SPRINTF, SchemaConnectorApiInterface::KEY_ENDPOINT_APPS));
        $api->getMultiple($skipCache);
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
                sprintf(SchemaConnectorApiInterface::API_URL_APP_SPRINTF, 'test-endpoint-app-id'),
                [],
                self::authHeaders()
            )
            ->willReturn($data);

        $app = self::createStub(SchemaAppInterface::class);

        $appTransformer = self::createMock(SchemaAppTransformerInterface::class);
        $appTransformer->expects(self::once())->method('transform')->with($data)->willReturn($app);

        $api = self::createApi($requestSender, appTransformer: $appTransformer);

        self::assertSame($app, $api->getOneById('test-endpoint-app-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $app = self::createStub(SchemaAppInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-app-data']);

        $appTransformer = self::createMock(SchemaAppTransformerInterface::class);
        $appTransformer->expects(self::once())->method('transform')->willReturn($app);

        $api = self::createApi($requestSender, appTransformer: $appTransformer);

        // Second call for the same id is served from the cache without hitting the API.
        self::assertSame($app, $api->getOneById('test-endpoint-app-id'));
        self::assertSame($app, $api->getOneById('test-endpoint-app-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../apps'])]
    public function testGetOneByIdEncodesId(string $endpointAppId): void
    {
        $data = ['test-app-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(SchemaConnectorApiInterface::API_URL_APP_SPRINTF, rawurlencode($endpointAppId)),
                [],
                self::authHeaders()
            )
            ->willReturn($data);

        $app = self::createStub(SchemaAppInterface::class);

        $appTransformer = self::createMock(SchemaAppTransformerInterface::class);
        $appTransformer->expects(self::once())->method('transform')->with($data)->willReturn($app);

        $api = self::createApi($requestSender, appTransformer: $appTransformer);

        self::assertSame($app, $api->getOneById($endpointAppId));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $app = self::createStub(SchemaAppInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-app-data']);

        $appTransformer = self::createMock(SchemaAppTransformerInterface::class);
        $appTransformer->expects(self::exactly(2))->method('transform')->willReturn($app);

        $api = self::createApi($requestSender, appTransformer: $appTransformer);

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($app, $api->getOneById('test-endpoint-app-id'));
        self::assertSame($app, $api->getOneById('test-endpoint-app-id', true));
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
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = self::createApi($requestSender);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(SchemaConnectorApiInterface::UNEXPECTED_RESPONSE);
        $api->getOneById('test-endpoint-app-id', $skipCache);
    }

    /**
     * @return array<string, string>
     */
    private static function authHeaders(): array
    {
        return [
            ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
        ];
    }

    /**
     * @throws Exception
     */
    private static function createApi(
        JsonApiRequestSenderInterface $requestSender,
        ?SchemaAppTransformerInterface $appTransformer = null,
        ?SchemaAppsTransformerInterface $appsTransformer = null,
        ?InstalledSchemaAppTransformerInterface $installedTransformer = null,
        ?InstalledSchemaAppsTransformerInterface $installedsTransformer = null,
        ?SchemaPageTransformerInterface $pageTransformer = null,
    ): SchemaConnectorApi {
        return new SchemaConnectorApi(
            $requestSender,
            $appTransformer ?? self::createStub(SchemaAppTransformerInterface::class),
            $appsTransformer ?? self::createStub(SchemaAppsTransformerInterface::class),
            $installedTransformer ?? self::createStub(InstalledSchemaAppTransformerInterface::class),
            $installedsTransformer ?? self::createStub(InstalledSchemaAppsTransformerInterface::class),
            $pageTransformer ?? self::createStub(SchemaPageTransformerInterface::class),
            new Token('test-api-token'),
        );
    }
}
