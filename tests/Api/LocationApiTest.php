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
use ChristianBrown\SmartThings\Model\CreateLocationRequest;
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Model\LocationPatchField;
use ChristianBrown\SmartThings\Model\PatchLocationRequest;
use ChristianBrown\SmartThings\Model\UpdateLocationRequest;
use ChristianBrown\SmartThings\Serializer\CreateLocationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CreateLocationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PatchLocationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\PatchLocationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateLocationRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateLocationRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\LocationsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(CreateLocationRequest::class)]
#[CoversClass(CreateLocationRequestSerializer::class)]
#[CoversClass(LocationApi::class)]
#[CoversClass(LocationPatchField::class)]
#[CoversClass(PatchLocationRequest::class)]
#[CoversClass(PatchLocationRequestSerializer::class)]
#[CoversClass(Token::class)]
#[CoversClass(UpdateLocationRequest::class)]
#[CoversClass(UpdateLocationRequestSerializer::class)]
final class LocationApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateLocation(): void
    {
        $data = ['test-location-data'];

        $request = new CreateLocationRequest('Home', 'GBR');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(
                LocationApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $createLocationRequestSerializer = self::createMock(CreateLocationRequestSerializerInterface::class);
        $createLocationRequestSerializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $locationTransformer = self::createMock(LocationTransformerInterface::class);
        $locationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($location);

        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), $createLocationRequestSerializer, self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));
        $actual = $locationApi->createLocation($request);

        self::assertSame($location, $actual);
    }

    /**
     * createLocation() invalidates the cached location list, so a subsequent
     * getMultiple() call hits the API again instead of returning a stale list.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateLocationInvalidatesListCache(): void
    {
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')
            ->willReturn('test-location-id');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn([LocationApiInterface::KEY_ITEMS => ['test-item']]);
        $requestSender->expects(self::once())->method('post')
            ->willReturn(['test-location-data']);

        $locationTransformer = self::createStub(LocationTransformerInterface::class);
        $locationTransformer->method('transform')
            ->willReturn($location);

        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);
        $locationsTransformer->method('transform')
            ->willReturn([$location]);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));

        $locationApi->getMultiple();
        $locationApi->createLocation(new CreateLocationRequest('Home', 'GBR'));
        $locationApi->getMultiple();
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateLocationUnexpectedResponse(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->willReturn([]);

        $locationTransformer = self::createStub(LocationTransformerInterface::class);
        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(LocationApiInterface::UNEXPECTED_RESPONSE);
        $locationApi->createLocation(new CreateLocationRequest('Home', 'GBR'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteLocation(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
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

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));
        $locationApi->deleteLocation('test-location-id');

        $this->addToAssertionCount(1);
    }

    /**
     * deleteLocation() invalidates the cached copy of this location and the cached
     * location list, so subsequent lookups hit the API again.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteLocationInvalidatesCaches(): void
    {
        $location = self::createStub(LocationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturn(['test-location-data']);
        $requestSender->expects(self::once())->method('delete')
            ->willReturn([]);

        $locationTransformer = self::createStub(LocationTransformerInterface::class);
        $locationTransformer->method('transform')
            ->willReturn($location);

        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));

        $locationApi->getOneById('test-location-id');
        $locationApi->deleteLocation('test-location-id');
        $locationApi->getOneById('test-location-id');
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteLocationWithForce(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(
                sprintf(LocationApiInterface::API_URL_SPRINTF, 'test-location-id'),
                [LocationApiInterface::KEY_FORCE => 'true'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $locationTransformer = self::createStub(LocationTransformerInterface::class);
        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));
        $locationApi->deleteLocation('test-location-id', true);

        $this->addToAssertionCount(1);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testDeleteLocationWithForceFalse(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('delete')
            ->with(
                sprintf(LocationApiInterface::API_URL_SPRINTF, 'test-location-id'),
                [LocationApiInterface::KEY_FORCE => 'false'],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn([]);

        $locationTransformer = self::createStub(LocationTransformerInterface::class);
        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));
        $locationApi->deleteLocation('test-location-id', false);

        $this->addToAssertionCount(1);
    }

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

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));
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

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));

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

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));

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

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));

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

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));
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

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));

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

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));
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

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));

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

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(LocationApiInterface::UNEXPECTED_RESPONSE);
        $locationApi->getOneById('test-location-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testPatchLocation(): void
    {
        $data = ['test-location-data'];

        $request = (new PatchLocationRequest())->setLatitude(new LocationPatchField(51.5));

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('patch')
            ->with(
                sprintf(LocationApiInterface::API_URL_SPRINTF, 'test-location-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $patchLocationRequestSerializer = self::createMock(PatchLocationRequestSerializerInterface::class);
        $patchLocationRequestSerializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $location = self::createStub(LocationInterface::class);

        $locationTransformer = self::createMock(LocationTransformerInterface::class);
        $locationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($location);

        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), $patchLocationRequestSerializer);
        $actual = $locationApi->patchLocation('test-location-id', $request);

        self::assertSame($location, $actual);
    }

    /**
     * patchLocation() refreshes the cached copy of this location and invalidates the
     * cached location list, so a subsequent getOneById() reflects the change while
     * getMultiple() hits the API again.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testPatchLocationRefreshesCachesAndInvalidatesList(): void
    {
        $location = self::createStub(LocationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('patch')
            ->willReturn(['test-location-data']);
        $requestSender->expects(self::once())->method('get')
            ->willReturn([LocationApiInterface::KEY_ITEMS => ['test-item']]);

        $locationTransformer = self::createMock(LocationTransformerInterface::class);
        $locationTransformer->expects(self::once())
            ->method('transform')
            ->willReturn($location);

        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);
        $locationsTransformer->method('transform')
            ->willReturn([$location]);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));

        self::assertSame($location, $locationApi->patchLocation('test-location-id', new PatchLocationRequest()));
        self::assertSame($location, $locationApi->getOneById('test-location-id'));
        $locationApi->getMultiple();
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testPatchLocationUnexpectedResponse(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('patch')
            ->willReturn([]);

        $locationTransformer = self::createStub(LocationTransformerInterface::class);
        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(LocationApiInterface::UNEXPECTED_RESPONSE);
        $locationApi->patchLocation('test-location-id', new PatchLocationRequest());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateLocation(): void
    {
        $data = ['test-location-data'];

        $request = new UpdateLocationRequest('Home');

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->with(
                sprintf(LocationApiInterface::API_URL_SPRINTF, 'test-location-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ],
                ['test-serialized-request']
            )
            ->willReturn($data);

        $updateLocationRequestSerializer = self::createMock(UpdateLocationRequestSerializerInterface::class);
        $updateLocationRequestSerializer->expects(self::once())->method('serialize')
            ->with($request)
            ->willReturn(['test-serialized-request']);

        $location = self::createStub(LocationInterface::class);

        $locationTransformer = self::createMock(LocationTransformerInterface::class);
        $locationTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($location);

        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), $updateLocationRequestSerializer, self::createStub(PatchLocationRequestSerializerInterface::class));
        $actual = $locationApi->updateLocation('test-location-id', $request);

        self::assertSame($location, $actual);
    }

    /**
     * updateLocation() refreshes the cached copy of this location, so a subsequent
     * getOneById() for the same id is served from it.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateLocationPopulatesCache(): void
    {
        $location = self::createStub(LocationInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('put')
            ->willReturn(['test-location-data']);

        $locationTransformer = self::createMock(LocationTransformerInterface::class);
        $locationTransformer->expects(self::once())
            ->method('transform')
            ->willReturn($location);

        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));

        self::assertSame($location, $locationApi->updateLocation('test-location-id', new UpdateLocationRequest('Home')));
        self::assertSame($location, $locationApi->getOneById('test-location-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testUpdateLocationUnexpectedResponse(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('put')
            ->willReturn([]);

        $locationTransformer = self::createStub(LocationTransformerInterface::class);
        $locationsTransformer = self::createStub(LocationsTransformerInterface::class);

        $locationApi = new LocationApi($requestSender, $locationTransformer, $locationsTransformer, new Token('test-api-token'), self::createStub(CreateLocationRequestSerializerInterface::class), self::createStub(UpdateLocationRequestSerializerInterface::class), self::createStub(PatchLocationRequestSerializerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(LocationApiInterface::UNEXPECTED_RESPONSE);
        $locationApi->updateLocation('test-location-id', new UpdateLocationRequest('Home'));
    }
}
