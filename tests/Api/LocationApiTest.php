<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\LocationApi;
use ChristianBrown\SmartThings\Api\LocationApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Transformer\LocationsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;

use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(LocationApi::class)]
#[CoversClass(Token::class)]
final class LocationApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            LocationApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                LocationApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $locations = [self::createStub(LocationInterface::class), self::createStub(LocationInterface::class)];

        $locationTransformer = self::createStub(LocationTransformerInterface::class);

        $locationsTransformer = self::createMock(LocationsTransformerInterface::class);
        $locationsTransformer->expects(self::once())->method('transform')
            ->with($data[LocationApiInterface::KEY_ITEMS])
            ->willReturn($locations);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'));
        $actual = $locationApi->getMultiple();

        self::assertSame($locations, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            LocationApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $locations = [self::createStub(LocationInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $locationTransformer = self::createStub(LocationTransformerInterface::class);

        $locationsTransformer = self::createMock(LocationsTransformerInterface::class);
        $locationsTransformer->expects(self::once())
            ->method('transform')
            ->with($data[LocationApiInterface::KEY_ITEMS])
            ->willReturn($locations);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'));

        // Second call is served from the cache without hitting the API.
        self::assertSame($locations, $locationApi->getMultiple());
        self::assertSame($locations, $locationApi->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            LocationApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $locations = [self::createStub(LocationInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $locationTransformer = self::createStub(LocationTransformerInterface::class);

        $locationsTransformer = self::createMock(LocationsTransformerInterface::class);
        $locationsTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[LocationApiInterface::KEY_ITEMS])
            ->willReturn($locations);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($locations, $locationApi->getMultiple());
        self::assertSame($locations, $locationApi->getMultiple(true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[LocationApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[LocationApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                LocationApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $locationTransformer = self::createStub(LocationTransformerInterface::class);
        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(LocationApiInterface::UNEXPECTED_RESPONSE_SPRINTF, LocationApiInterface::KEY_ITEMS));
        $locationApi->getMultiple($skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneById(): void
    {
        $data = ['test-location-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationApiInterface::API_URL_SPRINTF, 'test-location-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $location = self::createStub(LocationInterface::class);

        $locationTransformer = self::createMock(LocationTransformerInterface::class);
        $locationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($location);

        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'));
        $actual = $locationApi->getOneById('test-location-id');

        self::assertSame($location, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdCaches(): void
    {
        $data = ['test-location-data'];

        $location = self::createStub(LocationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with(
                sprintf(LocationApiInterface::API_URL_SPRINTF, 'test-location-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $locationTransformer = self::createMock(LocationTransformerInterface::class);
        $locationTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($location);

        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'));

        // Second call for the same locationId is served from the cache without hitting the API.
        self::assertSame($location, $locationApi->getOneById('test-location-id'));
        self::assertSame($location, $locationApi->getOneById('test-location-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c'])]
    #[TestWith(['../../locations'])]
    public function testGetOneByIdEncodesId(string $locationId): void
    {
        $data = ['test-location-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(LocationApiInterface::API_URL_SPRINTF, rawurlencode($locationId)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $location = self::createStub(LocationInterface::class);

        $locationTransformer = self::createMock(LocationTransformerInterface::class);
        $locationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($location);

        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'));
        $actual = $locationApi->getOneById($locationId);

        self::assertSame($location, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSkipsCache(): void
    {
        $data = ['test-location-data'];

        $location = self::createStub(LocationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->with(
                sprintf(LocationApiInterface::API_URL_SPRINTF, 'test-location-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $locationTransformer = self::createMock(LocationTransformerInterface::class);
        $locationTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($location);

        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($location, $locationApi->getOneById('test-location-id'));
        self::assertSame($location, $locationApi->getOneById('test-location-id', true));
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
                sprintf(LocationApiInterface::API_URL_SPRINTF, 'test-location-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $locationTransformer = self::createStub(LocationTransformerInterface::class);
        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(LocationApiInterface::UNEXPECTED_RESPONSE);
        $locationApi->getOneById('test-location-id', $skipCache);
    }
}
