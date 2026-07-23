<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\SceneApi;
use ChristianBrown\SmartThings\Api\SceneApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SceneInterface;
use ChristianBrown\SmartThings\Transformer\ScenesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\SceneTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;

use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(SceneApi::class)]
#[CoversClass(Token::class)]
final class SceneApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            SceneApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                SceneApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $scenes = [self::createStub(SceneInterface::class), self::createStub(SceneInterface::class)];

        $sceneTransformer = self::createStub(SceneTransformerInterface::class);

        $scenesTransformer = self::createMock(ScenesTransformerInterface::class);
        $scenesTransformer->expects(self::once())->method('transform')
            ->with($data[SceneApiInterface::KEY_ITEMS])
            ->willReturn($scenes);

        $sceneApi = new SceneApi($requestSender, $sceneTransformer, $scenesTransformer, new Token('test-api-token'));
        $actual = $sceneApi->getMultiple();

        self::assertSame($scenes, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            SceneApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $scenes = [self::createStub(SceneInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $sceneTransformer = self::createStub(SceneTransformerInterface::class);

        $scenesTransformer = self::createMock(ScenesTransformerInterface::class);
        $scenesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[SceneApiInterface::KEY_ITEMS])
            ->willReturn($scenes);

        $sceneApi = new SceneApi($requestSender, $sceneTransformer, $scenesTransformer, new Token('test-api-token'));

        // Second call with the same filter is served from the cache without hitting the API.
        self::assertSame($scenes, $sceneApi->getMultiple());
        self::assertSame($scenes, $sceneApi->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCachesPerLocation(): void
    {
        $data = [
            SceneApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $scenes = [self::createStub(SceneInterface::class)];

        // A distinct locationId is a distinct cache key, so it hits the API again.
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $sceneTransformer = self::createStub(SceneTransformerInterface::class);

        $scenesTransformer = self::createMock(ScenesTransformerInterface::class);
        $scenesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[SceneApiInterface::KEY_ITEMS])
            ->willReturn($scenes);

        $sceneApi = new SceneApi($requestSender, $sceneTransformer, $scenesTransformer, new Token('test-api-token'));

        self::assertSame($scenes, $sceneApi->getMultiple());
        self::assertSame($scenes, $sceneApi->getMultiple('test-location-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleFiltersByLocation(): void
    {
        $data = [
            SceneApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                SceneApiInterface::API_URL,
                [SceneApiInterface::KEY_LOCATION_ID => 'test-location-id'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $scenes = [self::createStub(SceneInterface::class), self::createStub(SceneInterface::class)];

        $sceneTransformer = self::createStub(SceneTransformerInterface::class);

        $scenesTransformer = self::createMock(ScenesTransformerInterface::class);
        $scenesTransformer->expects(self::once())->method('transform')
            ->with($data[SceneApiInterface::KEY_ITEMS])
            ->willReturn($scenes);

        $sceneApi = new SceneApi($requestSender, $sceneTransformer, $scenesTransformer, new Token('test-api-token'));
        $actual = $sceneApi->getMultiple('test-location-id');

        self::assertSame($scenes, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            SceneApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $scenes = [self::createStub(SceneInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $sceneTransformer = self::createStub(SceneTransformerInterface::class);

        $scenesTransformer = self::createMock(ScenesTransformerInterface::class);
        $scenesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[SceneApiInterface::KEY_ITEMS])
            ->willReturn($scenes);

        $sceneApi = new SceneApi($requestSender, $sceneTransformer, $scenesTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($scenes, $sceneApi->getMultiple());
        self::assertSame($scenes, $sceneApi->getMultiple(null, true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[SceneApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[SceneApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                SceneApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $sceneTransformer = self::createStub(SceneTransformerInterface::class);
        $scenesTransformer = self::createStub(ScenesTransformerInterface::class);

        $sceneApi = new SceneApi($requestSender, $sceneTransformer, $scenesTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(SceneApiInterface::UNEXPECTED_RESPONSE_SPRINTF, SceneApiInterface::KEY_ITEMS));
        $sceneApi->getMultiple(null, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-scene-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(SceneApiInterface::API_URL_SPRINTF, 'test-scene-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $scene = self::createStub(SceneInterface::class);

        $sceneTransformer = self::createMock(SceneTransformerInterface::class);
        $sceneTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($scene);

        $scenesTransformer = self::createStub(ScenesTransformerInterface::class);

        $sceneApi = new SceneApi($requestSender, $sceneTransformer, $scenesTransformer, new Token('test-api-token'));
        $actual = $sceneApi->getOneById('test-scene-id');

        self::assertSame($scene, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $data = ['test-scene-data'];

        $scene = self::createStub(SceneInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                sprintf(SceneApiInterface::API_URL_SPRINTF, 'test-scene-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $sceneTransformer = self::createMock(SceneTransformerInterface::class);
        $sceneTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($scene);

        $scenesTransformer = self::createStub(ScenesTransformerInterface::class);

        $sceneApi = new SceneApi($requestSender, $sceneTransformer, $scenesTransformer, new Token('test-api-token'));

        // Second call for the same sceneId is served from the cache without hitting the API.
        self::assertSame($scene, $sceneApi->getOneById('test-scene-id'));
        self::assertSame($scene, $sceneApi->getOneById('test-scene-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../scenes'])]
    public function testGetOneByIdEncodesId(string $sceneId): void
    {
        $data = ['test-scene-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(SceneApiInterface::API_URL_SPRINTF, rawurlencode($sceneId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $scene = self::createStub(SceneInterface::class);

        $sceneTransformer = self::createMock(SceneTransformerInterface::class);
        $sceneTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($scene);

        $scenesTransformer = self::createStub(ScenesTransformerInterface::class);

        $sceneApi = new SceneApi($requestSender, $sceneTransformer, $scenesTransformer, new Token('test-api-token'));
        $actual = $sceneApi->getOneById($sceneId);

        self::assertSame($scene, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $data = ['test-scene-data'];

        $scene = self::createStub(SceneInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->with(
                sprintf(SceneApiInterface::API_URL_SPRINTF, 'test-scene-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $sceneTransformer = self::createMock(SceneTransformerInterface::class);
        $sceneTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($scene);

        $scenesTransformer = self::createStub(ScenesTransformerInterface::class);

        $sceneApi = new SceneApi($requestSender, $sceneTransformer, $scenesTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($scene, $sceneApi->getOneById('test-scene-id'));
        self::assertSame($scene, $sceneApi->getOneById('test-scene-id', true));
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
            ->with(
                sprintf(SceneApiInterface::API_URL_SPRINTF, 'test-scene-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $sceneTransformer = self::createStub(SceneTransformerInterface::class);
        $scenesTransformer = self::createStub(ScenesTransformerInterface::class);

        $sceneApi = new SceneApi($requestSender, $sceneTransformer, $scenesTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(SceneApiInterface::UNEXPECTED_RESPONSE);
        $sceneApi->getOneById('test-scene-id', $skipCache);
    }
}
