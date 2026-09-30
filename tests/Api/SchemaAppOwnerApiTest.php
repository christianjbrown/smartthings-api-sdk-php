<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\SchemaAppOwnerApi;
use ChristianBrown\SmartThings\Api\SchemaAppOwnerApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\OrganizationSchemaAppsInterface;
use ChristianBrown\SmartThings\Model\UserSchemaAppsInterface;
use ChristianBrown\SmartThings\Transformer\OrganizationSchemaAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\UserSchemaAppsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(SchemaAppOwnerApi::class)]
#[CoversClass(Token::class)]
final class SchemaAppOwnerApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testAnEmptyOrganizationResponseIsRejected(bool $skipCache): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);
        $api = new SchemaAppOwnerApi($requestSender, self::createStub(OrganizationSchemaAppsTransformerInterface::class), self::createStub(UserSchemaAppsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(SchemaAppOwnerApiInterface::UNEXPECTED_RESPONSE);

        $api->getOrganizationApps(null, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testAnEmptyUserResponseIsRejected(bool $skipCache): void
    {
        $requestSender = self::createStub(JsonApiRequestSenderInterface::class);
        $requestSender->method('get')->willReturn([]);
        $api = new SchemaAppOwnerApi($requestSender, self::createStub(OrganizationSchemaAppsTransformerInterface::class), self::createStub(UserSchemaAppsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(SchemaAppOwnerApiInterface::UNEXPECTED_RESPONSE);

        $api->getUserApps('test-user', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOrganizationAppsCachesPerOrganization(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [SchemaAppOwnerApiInterface::API_URL_ORGANIZATION_APPS, [], $this->headers(), ['plain']],
                [SchemaAppOwnerApiInterface::API_URL_ORGANIZATION_APPS, [], $this->headers() + [ApiInterface::HEADER_KEY_ORGANIZATION_ID => 'test-org'], ['scoped']],
            ]);
        $plain = self::createStub(OrganizationSchemaAppsInterface::class);
        $scoped = self::createStub(OrganizationSchemaAppsInterface::class);
        $transformer = self::createStub(OrganizationSchemaAppsTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['scoped'], $scoped]]);
        $api = new SchemaAppOwnerApi($requestSender, $transformer, self::createStub(UserSchemaAppsTransformerInterface::class), new Token('test-api-token'));

        self::assertSame($plain, $api->getOrganizationApps());
        self::assertSame($scoped, $api->getOrganizationApps('test-org'));
        self::assertSame($plain, $api->getOrganizationApps());
        self::assertSame($scoped, $api->getOrganizationApps('test-org'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOrganizationAppsSkipsTheCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['x']);
        $transformer = self::createStub(OrganizationSchemaAppsTransformerInterface::class);
        $transformer->method('transform')->willReturn(self::createStub(OrganizationSchemaAppsInterface::class));
        $api = new SchemaAppOwnerApi($requestSender, $transformer, self::createStub(UserSchemaAppsTransformerInterface::class), new Token('test-api-token'));

        $api->getOrganizationApps();
        $api->getOrganizationApps(null, true);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetUserAppsCaches(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(sprintf(SchemaAppOwnerApiInterface::API_URL_USER_APPS_SPRINTF, 'test-user'), [], $this->headers())
            ->willReturn(['data']);
        $apps = self::createStub(UserSchemaAppsInterface::class);
        $transformer = self::createMock(UserSchemaAppsTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')->with(['data'])->willReturn($apps);
        $api = new SchemaAppOwnerApi($requestSender, self::createStub(OrganizationSchemaAppsTransformerInterface::class), $transformer, new Token('test-api-token'));

        self::assertSame($apps, $api->getUserApps('test-user'));
        self::assertSame($apps, $api->getUserApps('test-user'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetUserAppsSkipsTheCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['x']);
        $transformer = self::createStub(UserSchemaAppsTransformerInterface::class);
        $transformer->method('transform')->willReturn(self::createStub(UserSchemaAppsInterface::class));
        $api = new SchemaAppOwnerApi($requestSender, self::createStub(OrganizationSchemaAppsTransformerInterface::class), $transformer, new Token('test-api-token'));

        $api->getUserApps('test-user');
        $api->getUserApps('test-user', true);
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
