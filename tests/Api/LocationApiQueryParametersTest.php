<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\LocationApi;
use ChristianBrown\SmartThings\Api\LocationApiInterface;
use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Model\CreateLocationRequestInterface;
use ChristianBrown\SmartThings\Model\LocationInterface;
use ChristianBrown\SmartThings\Model\LocationListQuery;
use ChristianBrown\SmartThings\Serializer\CreateLocationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\PatchLocationRequestSerializerInterface;
use ChristianBrown\SmartThings\Serializer\UpdateLocationRequestSerializerInterface;
use ChristianBrown\SmartThings\Transformer\LocationsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LocationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(LocationApi::class)]
#[CoversClass(RequestUrlBuilder::class)]
#[CoversClass(Token::class)]
#[CoversClass(LocationListQuery::class)]
final class LocationApiQueryParametersTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testCreateLocationSendsAllowed(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('post')
            ->with(LocationApiInterface::API_URL.'?allowed=false', [], $this->headers(), ['test-body'])
            ->willReturn(['test-data']);
        $serializer = self::createStub(CreateLocationRequestSerializerInterface::class);
        $serializer->method('serialize')->willReturn(['test-body']);
        $location = self::createStub(LocationInterface::class);
        $location->method('getLocationId')->willReturn('test-location-id');
        $transformer = self::createStub(LocationTransformerInterface::class);
        $transformer->method('transform')->willReturn($location);
        $api = $this->api($requestSender, createLocationRequestSerializer: $serializer, locationTransformer: $transformer);

        self::assertSame($location, $api->createLocation(self::createStub(CreateLocationRequestInterface::class), false));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleAppliesTheQuery(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [LocationApiInterface::API_URL, [], $this->headers(), [LocationApiInterface::KEY_ITEMS => ['plain']]],
                [LocationApiInterface::API_URL.'?allowed=true&limit=5&page=test-page', [], $this->headers(), [LocationApiInterface::KEY_ITEMS => ['variant']]],
            ]);
        $plain = [self::createStub(LocationInterface::class)];
        $variant = [self::createStub(LocationInterface::class)];
        $transformer = self::createStub(LocationsTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $query = (new LocationListQuery())->setAllowed(true)->setLimit(5)->setPage('test-page');
        $api = $this->api($requestSender, locationsTransformer: $transformer);

        self::assertSame($plain, $api->getMultiple());
        self::assertSame($variant, $api->getMultiple(false, $query));
        self::assertSame($plain, $api->getMultiple());
        self::assertSame($variant, $api->getMultiple(false, $query));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByIdSendsAllowedAndCachesPerVariant(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnMap([
                [sprintf(LocationApiInterface::API_URL_SPRINTF, 'test-location-id'), [], $this->headers(), ['plain']],
                [sprintf(LocationApiInterface::API_URL_SPRINTF, 'test-location-id').'?allowed=true', [], $this->headers(), ['variant']],
            ]);
        $plain = self::createStub(LocationInterface::class);
        $variant = self::createStub(LocationInterface::class);
        $transformer = self::createStub(LocationTransformerInterface::class);
        $transformer->method('transform')->willReturnMap([[['plain'], $plain], [['variant'], $variant]]);
        $api = $this->api($requestSender, locationTransformer: $transformer);

        self::assertSame($plain, $api->getOneById('test-location-id'));
        self::assertSame($variant, $api->getOneById('test-location-id', false, true));
        self::assertSame($plain, $api->getOneById('test-location-id'));
        self::assertSame($variant, $api->getOneById('test-location-id', false, true));
    }

    private function api(JsonApiRequestSenderInterface $requestSender, ?LocationTransformerInterface $locationTransformer = null, ?LocationsTransformerInterface $locationsTransformer = null, ?CreateLocationRequestSerializerInterface $createLocationRequestSerializer = null, ?UpdateLocationRequestSerializerInterface $updateLocationRequestSerializer = null, ?PatchLocationRequestSerializerInterface $patchLocationRequestSerializer = null): LocationApi
    {
        return new LocationApi($requestSender, $locationTransformer ?? self::createStub(LocationTransformerInterface::class), $locationsTransformer ?? self::createStub(LocationsTransformerInterface::class), new Token('test-api-token'), $createLocationRequestSerializer ?? self::createStub(CreateLocationRequestSerializerInterface::class), $updateLocationRequestSerializer ?? self::createStub(UpdateLocationRequestSerializerInterface::class), $patchLocationRequestSerializer ?? self::createStub(PatchLocationRequestSerializerInterface::class), new RequestUrlBuilder());
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        return [ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token')];
    }
}
