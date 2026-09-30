<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\LocationModeApi;
use ChristianBrown\SmartThings\Api\LocationModeApiInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Model\ModeInterface;
use ChristianBrown\SmartThings\Transformer\ModesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ModeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(LocationModeApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
final class LocationModeApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testChangeCurrent(): void
    {
        $data = ['test-mode-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $mode = self::createStub(ModeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(LocationModeApiInterface::API_URL_CURRENT_SPRINTF, 'test-location-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                [LocationModeApiInterface::KEY_MODE_ID => 'test-mode-id']
            )
            ->willReturn($data);

        $modeTransformer = self::createMock(ModeTransformerInterface::class);
        $modeTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($mode);

        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());
        $actual = $modeApi->changeCurrent($location, 'test-mode-id');

        self::assertSame($mode, $actual);
    }

    /**
     * changeCurrent() refreshes the current-mode cache, so a subsequent getCurrent()
     * for the same location is served from it without hitting the API again.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testChangeCurrentPopulatesCurrentCache(): void
    {
        $data = ['test-mode-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $mode = self::createStub(ModeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('put')
            ->willReturn($data);

        $modeTransformer = self::createMock(ModeTransformerInterface::class);
        $modeTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($mode);

        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        self::assertSame($mode, $modeApi->changeCurrent($location, 'test-mode-id'));
        self::assertSame($mode, $modeApi->getCurrent($location));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testChangeCurrentUnexpectedResponse(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn([]);

        $modeTransformer = self::createStub(ModeTransformerInterface::class);
        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(LocationModeApiInterface::UNEXPECTED_RESPONSE);
        $modeApi->changeCurrent($location, 'test-mode-id');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateMode(): void
    {
        $data = ['test-mode-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $mode = self::createStub(ModeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                sprintf(LocationModeApiInterface::API_URL_LIST_SPRINTF, 'test-location-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                [LocationModeApiInterface::KEY_LABEL => 'test-mode-label']
            )
            ->willReturn($data);

        $modeTransformer = self::createMock(ModeTransformerInterface::class);
        $modeTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($mode);

        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());
        $actual = $modeApi->createMode($location, 'test-mode-label');

        self::assertSame($mode, $actual);
    }

    /**
     * createMode() invalidates the cached mode list for this location, so a subsequent
     * getMultiple() call hits the API again instead of returning a stale list.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateModeInvalidatesListCache(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $mode = self::createStub(ModeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn([LocationModeApiInterface::KEY_ITEMS => ['test-item']]);
        $requestSender->expects(self::once())->method('post')
            ->willReturn(['test-mode-data']);

        $modeTransformer = self::createStub(ModeTransformerInterface::class);
        $modeTransformer->method('transform')
            ->willReturn($mode);

        $modesTransformer = self::createStub(ModesTransformerInterface::class);
        $modesTransformer->method('transform')
            ->willReturn([$mode]);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        $modeApi->getMultiple($location);
        $modeApi->createMode($location, 'test-mode-label');
        $modeApi->getMultiple($location);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateModeUnexpectedResponse(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $modeTransformer = self::createStub(ModeTransformerInterface::class);
        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(LocationModeApiInterface::UNEXPECTED_RESPONSE);
        $modeApi->createMode($location, 'test-mode-label');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteMode(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(
                sprintf(LocationModeApiInterface::API_URL_SPRINTF, 'test-location-id', 'test-mode-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $modeTransformer = self::createStub(ModeTransformerInterface::class);
        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());
        $modeApi->deleteMode($location, 'test-mode-id');

        $this->addToAssertionCount(1);
    }

    /**
     * deleteMode() invalidates both the cached copy of this mode and the cached mode
     * list for this location, so subsequent lookups hit the API again.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteModeInvalidatesCaches(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $mode = self::createStub(ModeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn(['test-mode-data']);
        $requestSender->expects(self::once())->method('delete')
            ->willReturn([]);

        $modeTransformer = self::createStub(ModeTransformerInterface::class);
        $modeTransformer->method('transform')
            ->willReturn($mode);

        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        $modeApi->getOneByLocationAndId($location, 'test-mode-id');
        $modeApi->deleteMode($location, 'test-mode-id');
        $modeApi->getOneByLocationAndId($location, 'test-mode-id');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCurrent(): void
    {
        $data = ['test-mode-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $mode = self::createStub(ModeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationModeApiInterface::API_URL_CURRENT_SPRINTF, 'test-location-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $modeTransformer = self::createMock(ModeTransformerInterface::class);
        $modeTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($mode);

        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());
        $actual = $modeApi->getCurrent($location);

        self::assertSame($mode, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCurrentCaches(): void
    {
        $data = ['test-mode-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $mode = self::createStub(ModeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $modeTransformer = self::createMock(ModeTransformerInterface::class);
        $modeTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($mode);

        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        // Second call for the same locationId is served from the cache without hitting the API.
        self::assertSame($mode, $modeApi->getCurrent($location));
        self::assertSame($mode, $modeApi->getCurrent($location));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetCurrentSkipsCache(): void
    {
        $data = ['test-mode-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $mode = self::createStub(ModeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $modeTransformer = self::createMock(ModeTransformerInterface::class);
        $modeTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($mode);

        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($mode, $modeApi->getCurrent($location));
        self::assertSame($mode, $modeApi->getCurrent($location, true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetCurrentUnexpectedResponse(bool $skipCache): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationModeApiInterface::API_URL_CURRENT_SPRINTF, 'test-location-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $modeTransformer = self::createStub(ModeTransformerInterface::class);
        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(LocationModeApiInterface::UNEXPECTED_RESPONSE);
        $modeApi->getCurrent($location, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            LocationModeApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationModeApiInterface::API_URL_LIST_SPRINTF, 'test-location-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $modes = [self::createStub(ModeInterface::class), self::createStub(ModeInterface::class)];

        $modeTransformer = self::createStub(ModeTransformerInterface::class);

        $modesTransformer = self::createMock(ModesTransformerInterface::class);
        $modesTransformer->expects(self::once())->method('transform')
            ->with($data[LocationModeApiInterface::KEY_ITEMS])
            ->willReturn($modes);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());
        $actual = $modeApi->getMultiple($location);

        self::assertSame($modes, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            LocationModeApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $modes = [self::createStub(ModeInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $modeTransformer = self::createStub(ModeTransformerInterface::class);

        $modesTransformer = self::createMock(ModesTransformerInterface::class);
        $modesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[LocationModeApiInterface::KEY_ITEMS])
            ->willReturn($modes);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        // Second call for the same locationId is served from the cache without hitting the API.
        self::assertSame($modes, $modeApi->getMultiple($location));
        self::assertSame($modes, $modeApi->getMultiple($location));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            LocationModeApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $modes = [self::createStub(ModeInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $modeTransformer = self::createStub(ModeTransformerInterface::class);

        $modesTransformer = self::createMock(ModesTransformerInterface::class);
        $modesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[LocationModeApiInterface::KEY_ITEMS])
            ->willReturn($modes);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($modes, $modeApi->getMultiple($location));
        self::assertSame($modes, $modeApi->getMultiple($location, true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[LocationModeApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[LocationModeApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn($data);

        $modeTransformer = self::createStub(ModeTransformerInterface::class);
        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocationModeApiInterface::UNEXPECTED_RESPONSE_SPRINTF, LocationModeApiInterface::KEY_ITEMS));
        $modeApi->getMultiple($location, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByLocationAndId(): void
    {
        $data = ['test-mode-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $mode = self::createStub(ModeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationModeApiInterface::API_URL_SPRINTF, 'test-location-id', 'test-mode-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $modeTransformer = self::createMock(ModeTransformerInterface::class);
        $modeTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($mode);

        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());
        $actual = $modeApi->getOneByLocationAndId($location, 'test-mode-id');

        self::assertSame($mode, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByLocationAndIdCaches(): void
    {
        $data = ['test-mode-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $mode = self::createStub(ModeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $modeTransformer = self::createMock(ModeTransformerInterface::class);
        $modeTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($mode);

        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        // Second call for the same modeId is served from the cache without hitting the API.
        self::assertSame($mode, $modeApi->getOneByLocationAndId($location, 'test-mode-id'));
        self::assertSame($mode, $modeApi->getOneByLocationAndId($location, 'test-mode-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c', 'x/y z'])]
    #[TestWith(['../../locations', '../../modes'])]
    public function testGetOneByLocationAndIdEncodesIds(string $locationId, string $modeId): void
    {
        $data = ['test-mode-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn($locationId);

        $mode = self::createStub(ModeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationModeApiInterface::API_URL_SPRINTF, rawurlencode($locationId), rawurlencode($modeId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $modeTransformer = self::createMock(ModeTransformerInterface::class);
        $modeTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($mode);

        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());
        $actual = $modeApi->getOneByLocationAndId($location, $modeId);

        self::assertSame($mode, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByLocationAndIdSkipsCache(): void
    {
        $data = ['test-mode-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $mode = self::createStub(ModeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $modeTransformer = self::createMock(ModeTransformerInterface::class);
        $modeTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($mode);

        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($mode, $modeApi->getOneByLocationAndId($location, 'test-mode-id'));
        self::assertSame($mode, $modeApi->getOneByLocationAndId($location, 'test-mode-id', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetOneByLocationAndIdUnexpectedResponse(bool $skipCache): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationModeApiInterface::API_URL_SPRINTF, 'test-location-id', 'test-mode-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $modeTransformer = self::createStub(ModeTransformerInterface::class);
        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(LocationModeApiInterface::UNEXPECTED_RESPONSE);
        $modeApi->getOneByLocationAndId($location, 'test-mode-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateMode(): void
    {
        $data = ['test-mode-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $mode = self::createStub(ModeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(LocationModeApiInterface::API_URL_SPRINTF, 'test-location-id', 'test-mode-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                [LocationModeApiInterface::KEY_LABEL => 'test-mode-label']
            )
            ->willReturn($data);

        $modeTransformer = self::createMock(ModeTransformerInterface::class);
        $modeTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($mode);

        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());
        $actual = $modeApi->updateMode($location, 'test-mode-id', 'test-mode-label');

        self::assertSame($mode, $actual);
    }

    /**
     * updateMode() refreshes the cached copy of this mode, so a subsequent
     * getOneByLocationAndId() for the same id is served from it.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateModePopulatesCache(): void
    {
        $data = ['test-mode-data'];

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $mode = self::createStub(ModeInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('put')
            ->willReturn($data);

        $modeTransformer = self::createMock(ModeTransformerInterface::class);
        $modeTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($mode);

        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        self::assertSame($mode, $modeApi->updateMode($location, 'test-mode-id', 'test-mode-label'));
        self::assertSame($mode, $modeApi->getOneByLocationAndId($location, 'test-mode-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateModeUnexpectedResponse(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn([]);

        $modeTransformer = self::createStub(ModeTransformerInterface::class);
        $modesTransformer = self::createStub(ModesTransformerInterface::class);

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'), new RequestUrlBuilder());

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(LocationModeApiInterface::UNEXPECTED_RESPONSE);
        $modeApi->updateMode($location, 'test-mode-id', 'test-mode-label');
    }
}
