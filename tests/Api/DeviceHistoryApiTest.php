<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\DeviceHistoryApi;
use ChristianBrown\SmartThings\Api\DeviceHistoryApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceHistoryEventInterface;
use ChristianBrown\SmartThings\Transformer\DeviceHistoryEventsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;

use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DeviceHistoryApi::class)]
#[CoversClass(Token::class)]
final class DeviceHistoryApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            DeviceHistoryApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DeviceHistoryApiInterface::API_URL,
                [
                    DeviceHistoryApiInterface::KEY_DEVICE_ID => 'test-device-id',
                    DeviceHistoryApiInterface::KEY_LOCATION_ID => 'test-location-id',
                    DeviceHistoryApiInterface::KEY_OLDEST_FIRST => DeviceHistoryApiInterface::OLDEST_FIRST_TRUE,
                ],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $events = [self::createStub(DeviceHistoryEventInterface::class)];

        $eventsTransformer = self::createMock(DeviceHistoryEventsTransformerInterface::class);
        $eventsTransformer->expects(self::once())->method('transform')
            ->with(['test-item-1', 'test-item-2'])
            ->willReturn($events);

        $api = new DeviceHistoryApi($requestSender, $eventsTransformer, new Token('test-api-token'));
        $actual = $api->getMultiple('test-device-id', 'test-location-id', true);

        self::assertSame($events, $actual);
    }

    /**
     * The query is built from exactly the filters supplied, across every
     * combination of the optional deviceId, locationId, and oldestFirst inputs.
     *
     * @param array<string, string> $expectedQuery
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[DataProvider('provideGetMultipleBuildsQueryCases')]
    public function testGetMultipleBuildsQuery(array $expectedQuery, ?string $deviceId, ?string $locationId, bool $oldestFirst): void
    {
        $data = [
            DeviceHistoryApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DeviceHistoryApiInterface::API_URL,
                $expectedQuery,
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $events = [self::createStub(DeviceHistoryEventInterface::class)];

        $eventsTransformer = self::createMock(DeviceHistoryEventsTransformerInterface::class);
        $eventsTransformer->expects(self::once())->method('transform')
            ->with(['test-item-1'])
            ->willReturn($events);

        $api = new DeviceHistoryApi($requestSender, $eventsTransformer, new Token('test-api-token'));
        $actual = $api->getMultiple($deviceId, $locationId, $oldestFirst);

        self::assertSame($events, $actual);
    }

    /**
     * @return iterable<string, array{array<string, string>, ?string, ?string, bool}>
     */
    public static function provideGetMultipleBuildsQueryCases(): iterable
    {
        $device = 'test-device-id';
        $location = 'test-location-id';
        $oldest = DeviceHistoryApiInterface::OLDEST_FIRST_TRUE;

        yield 'none' => [[], null, null, false];
        yield 'oldestOnly' => [[DeviceHistoryApiInterface::KEY_OLDEST_FIRST => $oldest], null, null, true];
        yield 'locationOnly' => [[DeviceHistoryApiInterface::KEY_LOCATION_ID => $location], null, $location, false];
        yield 'locationAndOldest' => [[DeviceHistoryApiInterface::KEY_LOCATION_ID => $location, DeviceHistoryApiInterface::KEY_OLDEST_FIRST => $oldest], null, $location, true];
        yield 'deviceOnly' => [[DeviceHistoryApiInterface::KEY_DEVICE_ID => $device], $device, null, false];
        yield 'deviceAndOldest' => [[DeviceHistoryApiInterface::KEY_DEVICE_ID => $device, DeviceHistoryApiInterface::KEY_OLDEST_FIRST => $oldest], $device, null, true];
        yield 'deviceAndLocation' => [[DeviceHistoryApiInterface::KEY_DEVICE_ID => $device, DeviceHistoryApiInterface::KEY_LOCATION_ID => $location], $device, $location, false];
        yield 'all' => [[DeviceHistoryApiInterface::KEY_DEVICE_ID => $device, DeviceHistoryApiInterface::KEY_LOCATION_ID => $location, DeviceHistoryApiInterface::KEY_OLDEST_FIRST => $oldest], $device, $location, true];
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            DeviceHistoryApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $events = [self::createStub(DeviceHistoryEventInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $eventsTransformer = self::createMock(DeviceHistoryEventsTransformerInterface::class);
        $eventsTransformer->expects(self::once())
            ->method('transform')
            ->with(['test-item-1'])
            ->willReturn($events);

        $api = new DeviceHistoryApi($requestSender, $eventsTransformer, new Token('test-api-token'));

        // Second call with the same arguments is served from the cache without hitting the API.
        self::assertSame($events, $api->getMultiple('test-device-id'));
        self::assertSame($events, $api->getMultiple('test-device-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleEmptyItems(): void
    {
        $data = [
            DeviceHistoryApiInterface::KEY_ITEMS => [],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn($data);

        // An empty items array is a valid, non-error result.
        $eventsTransformer = self::createMock(DeviceHistoryEventsTransformerInterface::class);
        $eventsTransformer->expects(self::once())->method('transform')
            ->with([])
            ->willReturn([]);

        $api = new DeviceHistoryApi($requestSender, $eventsTransformer, new Token('test-api-token'));

        self::assertSame([], $api->getMultiple());
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleFollowsNextLink(): void
    {
        $page1 = [
            DeviceHistoryApiInterface::KEY_ITEMS => ['test-item-1'],
            DeviceHistoryApiInterface::KEY_LINKS => [
                DeviceHistoryApiInterface::KEY_NEXT => [
                    DeviceHistoryApiInterface::KEY_HREF => 'https://api.smartthings.com/v1/history/devices?page=2',
                ],
            ],
        ];
        $page2 = [
            DeviceHistoryApiInterface::KEY_ITEMS => ['test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $matcher = self::exactly(2);
        $requestSender->expects($matcher)->method('get')
            ->willReturnCallback(static function (string $url, array $query, array $headers) use ($matcher, $page1, $page2): array {
                if (1 === $matcher->numberOfInvocations()) {
                    self::assertSame(DeviceHistoryApiInterface::API_URL, $url);
                    self::assertSame([], $query);

                    return $page1;
                }

                self::assertSame('https://api.smartthings.com/v1/history/devices?page=2', $url);
                self::assertSame([], $query);

                return $page2;
            });

        $events = [self::createStub(DeviceHistoryEventInterface::class)];

        $eventsTransformer = self::createMock(DeviceHistoryEventsTransformerInterface::class);
        $eventsTransformer->expects(self::once())->method('transform')
            ->with(['test-item-1', 'test-item-2'])
            ->willReturn($events);

        $api = new DeviceHistoryApi($requestSender, $eventsTransformer, new Token('test-api-token'));
        $actual = $api->getMultiple();

        self::assertSame($events, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleRespectsMaxPages(): void
    {
        $page1 = [
            DeviceHistoryApiInterface::KEY_ITEMS => ['test-item-1'],
            DeviceHistoryApiInterface::KEY_LINKS => [
                DeviceHistoryApiInterface::KEY_NEXT => [
                    DeviceHistoryApiInterface::KEY_HREF => 'https://api.smartthings.com/v1/history/devices?page=2',
                ],
            ],
        ];

        // With maxPages = 1 the client stops after the first page even though a
        // next link is present, so only one request is made.
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn($page1);

        $events = [self::createStub(DeviceHistoryEventInterface::class)];

        $eventsTransformer = self::createMock(DeviceHistoryEventsTransformerInterface::class);
        $eventsTransformer->expects(self::once())->method('transform')
            ->with(['test-item-1'])
            ->willReturn($events);

        $api = new DeviceHistoryApi($requestSender, $eventsTransformer, new Token('test-api-token'));
        $actual = $api->getMultiple(null, null, false, 1);

        self::assertSame($events, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            DeviceHistoryApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $events = [self::createStub(DeviceHistoryEventInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $eventsTransformer = self::createMock(DeviceHistoryEventsTransformerInterface::class);
        $eventsTransformer->expects(self::exactly(2))->method('transform')
            ->with(['test-item-1'])
            ->willReturn($events);

        $api = new DeviceHistoryApi($requestSender, $eventsTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($events, $api->getMultiple('test-device-id'));
        self::assertSame($events, $api->getMultiple('test-device-id', null, false, null, true));
    }

    /**
     * When the page cap is not reached on the first page, the client keeps
     * following next links until the cap is hit — even if further pages remain.
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleStopsAtMaxPagesAcrossPages(): void
    {
        $page1 = [
            DeviceHistoryApiInterface::KEY_ITEMS => ['test-item-1'],
            DeviceHistoryApiInterface::KEY_LINKS => [
                DeviceHistoryApiInterface::KEY_NEXT => [
                    DeviceHistoryApiInterface::KEY_HREF => 'https://api.smartthings.com/v1/history/devices?page=2',
                ],
            ],
        ];
        $page2 = [
            DeviceHistoryApiInterface::KEY_ITEMS => ['test-item-2'],
            DeviceHistoryApiInterface::KEY_LINKS => [
                DeviceHistoryApiInterface::KEY_NEXT => [
                    DeviceHistoryApiInterface::KEY_HREF => 'https://api.smartthings.com/v1/history/devices?page=3',
                ],
            ],
        ];

        // maxPages = 2: page 1 is under the cap so its next link is followed, but
        // page 2 hits the cap and its next link is ignored — two requests total.
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $matcher = self::exactly(2);
        $requestSender->expects($matcher)->method('get')
            ->willReturnCallback(static function (string $url, array $query, array $headers) use ($matcher, $page1, $page2): array {
                if (1 === $matcher->numberOfInvocations()) {
                    return $page1;
                }

                return $page2;
            });

        $events = [self::createStub(DeviceHistoryEventInterface::class)];

        $eventsTransformer = self::createMock(DeviceHistoryEventsTransformerInterface::class);
        $eventsTransformer->expects(self::once())->method('transform')
            ->with(['test-item-1', 'test-item-2'])
            ->willReturn($events);

        $api = new DeviceHistoryApi($requestSender, $eventsTransformer, new Token('test-api-token'));
        $actual = $api->getMultiple(null, null, false, 2);

        self::assertSame($events, $actual);
    }

    /**
     * The next link is ignored (a single page is returned) whenever the
     * `_links.next.href` chain is missing or mis-typed at any level.
     *
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[DataProvider('provideGetMultipleStopsWhenNoNextLinkCases')]
    public function testGetMultipleStopsWhenNoNextLink(array $data): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn($data);

        $events = [self::createStub(DeviceHistoryEventInterface::class)];

        $eventsTransformer = self::createMock(DeviceHistoryEventsTransformerInterface::class);
        $eventsTransformer->expects(self::once())->method('transform')
            ->with(['test-item-1'])
            ->willReturn($events);

        $api = new DeviceHistoryApi($requestSender, $eventsTransformer, new Token('test-api-token'));

        self::assertSame($events, $api->getMultiple());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideGetMultipleStopsWhenNoNextLinkCases(): iterable
    {
        $items = [DeviceHistoryApiInterface::KEY_ITEMS => ['test-item-1']];

        yield 'linksAbsent' => [$items];
        yield 'linksNotArray' => [$items + [DeviceHistoryApiInterface::KEY_LINKS => 'not-an-array']];
        yield 'nextAbsent' => [$items + [DeviceHistoryApiInterface::KEY_LINKS => []]];
        yield 'nextNotArray' => [$items + [DeviceHistoryApiInterface::KEY_LINKS => [DeviceHistoryApiInterface::KEY_NEXT => 'not-an-array']]];
        yield 'hrefAbsent' => [$items + [DeviceHistoryApiInterface::KEY_LINKS => [DeviceHistoryApiInterface::KEY_NEXT => []]]];
        yield 'hrefEmpty' => [$items + [DeviceHistoryApiInterface::KEY_LINKS => [DeviceHistoryApiInterface::KEY_NEXT => [DeviceHistoryApiInterface::KEY_HREF => '']]]];
        yield 'hrefNotString' => [$items + [DeviceHistoryApiInterface::KEY_LINKS => [DeviceHistoryApiInterface::KEY_NEXT => [DeviceHistoryApiInterface::KEY_HREF => 42]]]];
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[DeviceHistoryApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[DeviceHistoryApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn($data);

        $api = new DeviceHistoryApi($requestSender, self::createStub(DeviceHistoryEventsTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(DeviceHistoryApiInterface::UNEXPECTED_RESPONSE_SPRINTF, DeviceHistoryApiInterface::KEY_ITEMS));
        $api->getMultiple(null, null, false, null, $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleWithoutFilters(): void
    {
        $data = [
            DeviceHistoryApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                DeviceHistoryApiInterface::API_URL,
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $events = [self::createStub(DeviceHistoryEventInterface::class)];

        $eventsTransformer = self::createMock(DeviceHistoryEventsTransformerInterface::class);
        $eventsTransformer->expects(self::once())->method('transform')
            ->with(['test-item-1'])
            ->willReturn($events);

        $api = new DeviceHistoryApi($requestSender, $eventsTransformer, new Token('test-api-token'));
        $actual = $api->getMultiple();

        self::assertSame($events, $actual);
    }
}
