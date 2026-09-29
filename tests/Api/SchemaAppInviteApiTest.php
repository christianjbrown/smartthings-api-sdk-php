<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\SchemaAppInviteApi;
use ChristianBrown\SmartThings\Api\SchemaAppInviteApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SchemaAppInviteAcceptanceInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInvitePageInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInviteReceiptInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInviteRequestInterface;
use ChristianBrown\SmartThings\Model\SchemaAppInviteStatusInterface;
use ChristianBrown\SmartThings\Serializer\SchemaAppInviteRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteAcceptanceTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppInvitePageTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteReceiptTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteStatusTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(SchemaAppInviteApi::class)]
#[CoversClass(Token::class)]
final class SchemaAppInviteApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testAcceptInvite(): void
    {
        $data = ['test-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(SchemaAppInviteApiInterface::API_URL_ACCEPT_SPRINTF, 'test-short-code'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $model = self::createStub(SchemaAppInviteAcceptanceInterface::class);

        $transformer = self::createMock(SchemaAppInviteAcceptanceTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new SchemaAppInviteApi($requestSender, new Token('test-api-token'), self::createStub(SchemaAppInviteRequestSerializerInterface::class), self::createStub(SchemaAppInviteReceiptTransformerInterface::class), $transformer, self::createStub(SchemaAppInvitePageTransformerInterface::class), self::createStub(SchemaAppInviteStatusTransformerInterface::class));
        $actual = $api->acceptInvite('test-short-code');

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testAcceptInviteUnexpectedResponse(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn([]);

        $api = new SchemaAppInviteApi($requestSender, new Token('test-api-token'), self::createStub(SchemaAppInviteRequestSerializerInterface::class), self::createStub(SchemaAppInviteReceiptTransformerInterface::class), self::createStub(SchemaAppInviteAcceptanceTransformerInterface::class), self::createStub(SchemaAppInvitePageTransformerInterface::class), self::createStub(SchemaAppInviteStatusTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(SchemaAppInviteApiInterface::UNEXPECTED_RESPONSE);
        $api->acceptInvite('test-short-code');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCheckAcceptance(): void
    {
        $data = ['test-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                SchemaAppInviteApiInterface::API_URL_CHECK_ACCEPTANCE,
                [SchemaAppInviteApiInterface::KEY_INVITATION_ID => 'test-invitation-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $model = self::createStub(SchemaAppInviteStatusInterface::class);

        $transformer = self::createMock(SchemaAppInviteStatusTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new SchemaAppInviteApi($requestSender, new Token('test-api-token'), self::createStub(SchemaAppInviteRequestSerializerInterface::class), self::createStub(SchemaAppInviteReceiptTransformerInterface::class), self::createStub(SchemaAppInviteAcceptanceTransformerInterface::class), self::createStub(SchemaAppInvitePageTransformerInterface::class), $transformer);
        $actual = $api->checkAcceptance('test-invitation-id');

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCheckAcceptanceUnexpectedResponse(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = new SchemaAppInviteApi($requestSender, new Token('test-api-token'), self::createStub(SchemaAppInviteRequestSerializerInterface::class), self::createStub(SchemaAppInviteReceiptTransformerInterface::class), self::createStub(SchemaAppInviteAcceptanceTransformerInterface::class), self::createStub(SchemaAppInvitePageTransformerInterface::class), self::createStub(SchemaAppInviteStatusTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(SchemaAppInviteApiInterface::UNEXPECTED_RESPONSE);
        $api->checkAcceptance('test-invitation-id');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateInvite(): void
    {
        $data = ['test-data'];

        $request = self::createStub(SchemaAppInviteRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                SchemaAppInviteApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(SchemaAppInviteRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(SchemaAppInviteReceiptInterface::class);

        $transformer = self::createMock(SchemaAppInviteReceiptTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new SchemaAppInviteApi($requestSender, new Token('test-api-token'), $serializer, $transformer, self::createStub(SchemaAppInviteAcceptanceTransformerInterface::class), self::createStub(SchemaAppInvitePageTransformerInterface::class), self::createStub(SchemaAppInviteStatusTransformerInterface::class));
        $actual = $api->createInvite($request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateInviteUnexpectedResponse(): void
    {
        $request = self::createStub(SchemaAppInviteRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $api = new SchemaAppInviteApi($requestSender, new Token('test-api-token'), self::createStub(SchemaAppInviteRequestSerializerInterface::class), self::createStub(SchemaAppInviteReceiptTransformerInterface::class), self::createStub(SchemaAppInviteAcceptanceTransformerInterface::class), self::createStub(SchemaAppInvitePageTransformerInterface::class), self::createStub(SchemaAppInviteStatusTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(SchemaAppInviteApiInterface::UNEXPECTED_RESPONSE);
        $api->createInvite($request);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInvites(): void
    {
        $data = ['test-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                SchemaAppInviteApiInterface::API_URL,
                [SchemaAppInviteApiInterface::KEY_SCHEMA_APP_ID => 'test-schema-app-id', SchemaAppInviteApiInterface::KEY_LIMIT => '3', SchemaAppInviteApiInterface::KEY_PAGE => 'test-page'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $model = self::createStub(SchemaAppInvitePageInterface::class);

        $transformer = self::createMock(SchemaAppInvitePageTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new SchemaAppInviteApi($requestSender, new Token('test-api-token'), self::createStub(SchemaAppInviteRequestSerializerInterface::class), self::createStub(SchemaAppInviteReceiptTransformerInterface::class), self::createStub(SchemaAppInviteAcceptanceTransformerInterface::class), $transformer, self::createStub(SchemaAppInviteStatusTransformerInterface::class));
        $actual = $api->getInvites('test-schema-app-id', 3, 'test-page');

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInvitesUnexpectedResponse(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = new SchemaAppInviteApi($requestSender, new Token('test-api-token'), self::createStub(SchemaAppInviteRequestSerializerInterface::class), self::createStub(SchemaAppInviteReceiptTransformerInterface::class), self::createStub(SchemaAppInviteAcceptanceTransformerInterface::class), self::createStub(SchemaAppInvitePageTransformerInterface::class), self::createStub(SchemaAppInviteStatusTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(SchemaAppInviteApiInterface::UNEXPECTED_RESPONSE);
        $api->getInvites('test-schema-app-id');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInvitesWithoutOptionalParameters(): void
    {
        $data = ['test-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                SchemaAppInviteApiInterface::API_URL,
                [SchemaAppInviteApiInterface::KEY_SCHEMA_APP_ID => 'test-schema-app-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $model = self::createStub(SchemaAppInvitePageInterface::class);

        $transformer = self::createMock(SchemaAppInvitePageTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new SchemaAppInviteApi($requestSender, new Token('test-api-token'), self::createStub(SchemaAppInviteRequestSerializerInterface::class), self::createStub(SchemaAppInviteReceiptTransformerInterface::class), self::createStub(SchemaAppInviteAcceptanceTransformerInterface::class), $transformer, self::createStub(SchemaAppInviteStatusTransformerInterface::class));
        $actual = $api->getInvites('test-schema-app-id');

        self::assertSame($model, $actual);
    }
}
