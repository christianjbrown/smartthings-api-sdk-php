<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\PresentationApi;
use ChristianBrown\SmartThings\Api\PresentationApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\PresentationInterface;
use ChristianBrown\SmartThings\Transformer\PresentationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;

use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(PresentationApi::class)]
#[CoversClass(Token::class)]
final class PresentationApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDeviceConfig(): void
    {
        $data = ['test-presentation-data'];

        // Without a manufacturerName the query carries only the presentationId.
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                PresentationApiInterface::API_URL_DEVICE_CONFIG,
                [PresentationApiInterface::KEY_PRESENTATION_ID => 'test-presentation-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $presentation = self::createStub(PresentationInterface::class);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'));
        $actual = $presentationApi->getDeviceConfig('test-presentation-id');

        self::assertSame($presentation, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDeviceConfigByType(): void
    {
        $data = ['test-presentation-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(PresentationApiInterface::API_URL_TYPE_DEVICE_CONFIG_SPRINTF, 'test-type-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $presentation = self::createStub(PresentationInterface::class);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'));
        $actual = $presentationApi->getDeviceConfigByType('test-type-id');

        self::assertSame($presentation, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDeviceConfigByTypeCaches(): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(PresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'));

        // Second call for the same type id is served from the cache without hitting the API.
        self::assertSame($presentation, $presentationApi->getDeviceConfigByType('test-type-id'));
        self::assertSame($presentation, $presentationApi->getDeviceConfigByType('test-type-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../presentation'])]
    public function testGetDeviceConfigByTypeEncodesId(string $typeIntegrationId): void
    {
        $data = ['test-presentation-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(PresentationApiInterface::API_URL_TYPE_DEVICE_CONFIG_SPRINTF, rawurlencode($typeIntegrationId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $presentation = self::createStub(PresentationInterface::class);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'));
        $actual = $presentationApi->getDeviceConfigByType($typeIntegrationId);

        self::assertSame($presentation, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDeviceConfigByTypeSkipsCache(): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(PresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($presentation, $presentationApi->getDeviceConfigByType('test-type-id'));
        self::assertSame($presentation, $presentationApi->getDeviceConfigByType('test-type-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetDeviceConfigByTypeUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn([]);

        $presentationTransformer = self::createStub(PresentationTransformerInterface::class);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PresentationApiInterface::UNEXPECTED_RESPONSE);
        $presentationApi->getDeviceConfigByType('test-type-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDeviceConfigCaches(): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(PresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'));

        // Second call for the same key is served from the cache without hitting the API.
        self::assertSame($presentation, $presentationApi->getDeviceConfig('test-presentation-id'));
        self::assertSame($presentation, $presentationApi->getDeviceConfig('test-presentation-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetDeviceConfigSkipsCache(): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(PresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($presentation, $presentationApi->getDeviceConfig('test-presentation-id'));
        self::assertSame($presentation, $presentationApi->getDeviceConfig('test-presentation-id', null, true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetDeviceConfigUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn([]);

        $presentationTransformer = self::createStub(PresentationTransformerInterface::class);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PresentationApiInterface::UNEXPECTED_RESPONSE);
        $presentationApi->getDeviceConfig('test-presentation-id', null, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOne(): void
    {
        $data = ['test-presentation-data'];

        // With a manufacturerName the query carries both filters.
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                PresentationApiInterface::API_URL,
                [
                    PresentationApiInterface::KEY_PRESENTATION_ID => 'test-presentation-id',
                    PresentationApiInterface::KEY_MANUFACTURER_NAME => 'test-manufacturer',
                ],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $presentation = self::createStub(PresentationInterface::class);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'));
        $actual = $presentationApi->getOne('test-presentation-id', 'test-manufacturer');

        self::assertSame($presentation, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneCaches(): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(PresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'));

        // Second call for the same key is served from the cache without hitting the API.
        self::assertSame($presentation, $presentationApi->getOne('test-presentation-id', 'test-manufacturer'));
        self::assertSame($presentation, $presentationApi->getOne('test-presentation-id', 'test-manufacturer'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneSkipsCache(): void
    {
        $data = ['test-presentation-data'];

        $presentation = self::createStub(PresentationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $presentationTransformer = self::createMock(PresentationTransformerInterface::class);
        $presentationTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($presentation);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($presentation, $presentationApi->getOne('test-presentation-id', 'test-manufacturer'));
        self::assertSame($presentation, $presentationApi->getOne('test-presentation-id', 'test-manufacturer', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetOneUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn([]);

        $presentationTransformer = self::createStub(PresentationTransformerInterface::class);

        $presentationApi = new PresentationApi($requestSender, $presentationTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(PresentationApiInterface::UNEXPECTED_RESPONSE);
        $presentationApi->getOne('test-presentation-id', null, $skipCache);
    }
}
