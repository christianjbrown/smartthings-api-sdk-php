<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\LocationModeApi;
use ChristianBrown\SmartThings\Api\LocationModeApiInterface;
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
#[CoversClass(Token::class)]
final class LocationModeApiTest extends TestCase
{
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

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'));
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

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'));

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

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'));

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

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'));

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

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'));
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

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'));

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

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'));

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

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'));

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

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'));
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

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'));

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

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'));
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

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'));

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

        $modeApi = new LocationModeApi($requestSender, $modeTransformer, $modesTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(LocationModeApiInterface::UNEXPECTED_RESPONSE);
        $modeApi->getOneByLocationAndId($location, 'test-mode-id', $skipCache);
    }
}
