<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\TextToSpeechApi;
use ChristianBrown\SmartThings\Api\TextToSpeechApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ConvertedTtsInterface;
use ChristianBrown\SmartThings\Model\PlayedTextInterface;
use ChristianBrown\SmartThings\Model\PlayTextRequestInterface;
use ChristianBrown\SmartThings\Model\TtsInfoInterface;
use ChristianBrown\SmartThings\Model\TtsRequestInterface;
use ChristianBrown\SmartThings\Serializer\PlayTextRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\TtsRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\ConvertedTtsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\PlayedTextTransformerInterface;
use ChristianBrown\SmartThings\Transformer\TtsInfoTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(TextToSpeechApi::class)]
#[CoversClass(Token::class)]
final class TextToSpeechApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testConvert(): void
    {
        $data = ['test-data'];

        $request = self::createStub(TtsRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                TextToSpeechApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(TtsRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(ConvertedTtsInterface::class);

        $transformer = self::createMock(ConvertedTtsTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new TextToSpeechApi($requestSender, new Token('test-api-token'), self::createStub(TtsInfoTransformerInterface::class), $serializer, $transformer, self::createStub(PlayTextRequestSerializerInterface::class), self::createStub(PlayedTextTransformerInterface::class));
        $actual = $api->convert($request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testConvertUnexpectedResponse(): void
    {
        $request = self::createStub(TtsRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $api = new TextToSpeechApi($requestSender, new Token('test-api-token'), self::createStub(TtsInfoTransformerInterface::class), self::createStub(TtsRequestSerializerInterface::class), self::createStub(ConvertedTtsTransformerInterface::class), self::createStub(PlayTextRequestSerializerInterface::class), self::createStub(PlayedTextTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(TextToSpeechApiInterface::UNEXPECTED_RESPONSE);
        $api->convert($request);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInfo(): void
    {
        $data = ['test-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                TextToSpeechApiInterface::API_URL_INFO,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $model = self::createStub(TtsInfoInterface::class);

        $transformer = self::createMock(TtsInfoTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new TextToSpeechApi($requestSender, new Token('test-api-token'), $transformer, self::createStub(TtsRequestSerializerInterface::class), self::createStub(ConvertedTtsTransformerInterface::class), self::createStub(PlayTextRequestSerializerInterface::class), self::createStub(PlayedTextTransformerInterface::class));
        $actual = $api->getInfo();

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInfoCaches(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn(['test-data']);

        $transformer = self::createMock(TtsInfoTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')->willReturn(self::createStub(TtsInfoInterface::class));

        $api = new TextToSpeechApi($requestSender, new Token('test-api-token'), $transformer, self::createStub(TtsRequestSerializerInterface::class), self::createStub(ConvertedTtsTransformerInterface::class), self::createStub(PlayTextRequestSerializerInterface::class), self::createStub(PlayedTextTransformerInterface::class));

        // Second call for the same key is served from the cache without hitting the API.
        $api->getInfo();
        $api->getInfo();
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetInfoSkipsCache(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')->willReturn(['test-data']);

        $transformer = self::createMock(TtsInfoTransformerInterface::class);
        $transformer->expects(self::exactly(2))->method('transform')->willReturn(self::createStub(TtsInfoInterface::class));

        $api = new TextToSpeechApi($requestSender, new Token('test-api-token'), $transformer, self::createStub(TtsRequestSerializerInterface::class), self::createStub(ConvertedTtsTransformerInterface::class), self::createStub(PlayTextRequestSerializerInterface::class), self::createStub(PlayedTextTransformerInterface::class));

        // First call populates the cache; the second bypasses it and hits the API again.
        $api->getInfo();
        $api->getInfo(skipCache: true);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetInfoUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn([]);

        $api = new TextToSpeechApi($requestSender, new Token('test-api-token'), self::createStub(TtsInfoTransformerInterface::class), self::createStub(TtsRequestSerializerInterface::class), self::createStub(ConvertedTtsTransformerInterface::class), self::createStub(PlayTextRequestSerializerInterface::class), self::createStub(PlayedTextTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(TextToSpeechApiInterface::UNEXPECTED_RESPONSE);
        $api->getInfo(skipCache: $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testPlayText(): void
    {
        $data = ['test-data'];

        $request = self::createStub(PlayTextRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                TextToSpeechApiInterface::API_URL_PLAYTEXT,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $serializer = self::createMock(PlayTextRequestSerializerInterface::class);
        $serializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $model = self::createStub(PlayedTextInterface::class);

        $transformer = self::createMock(PlayedTextTransformerInterface::class);
        $transformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($model);

        $api = new TextToSpeechApi($requestSender, new Token('test-api-token'), self::createStub(TtsInfoTransformerInterface::class), self::createStub(TtsRequestSerializerInterface::class), self::createStub(ConvertedTtsTransformerInterface::class), $serializer, $transformer);
        $actual = $api->playText($request);

        self::assertSame($model, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testPlayTextUnexpectedResponse(): void
    {
        $request = self::createStub(PlayTextRequestInterface::class);
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $api = new TextToSpeechApi($requestSender, new Token('test-api-token'), self::createStub(TtsInfoTransformerInterface::class), self::createStub(TtsRequestSerializerInterface::class), self::createStub(ConvertedTtsTransformerInterface::class), self::createStub(PlayTextRequestSerializerInterface::class), self::createStub(PlayedTextTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(TextToSpeechApiInterface::UNEXPECTED_RESPONSE);
        $api->playText($request);
    }
}
