<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiInterface;
use ChristianBrown\SmartThings\Api\ScheduleApi;
use ChristianBrown\SmartThings\Api\ScheduleApiInterface;
use ChristianBrown\SmartThings\Api\Token;
use ChristianBrown\SmartThings\Api\TokenInterface;
use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ScheduleInterface;
use ChristianBrown\SmartThings\Transformer\SchedulesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ScheduleTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\Exception;

use PHPUnit\Framework\TestCase;

use function rawurlencode;
use function sprintf;

#[CoversClass(ScheduleApi::class)]
#[CoversClass(Token::class)]
final class ScheduleApiTest extends TestCase
{
    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultiple(): void
    {
        $data = [
            ScheduleApiInterface::KEY_ITEMS => ['test-item-1', 'test-item-2'],
        ];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(ScheduleApiInterface::API_URL_LIST_SPRINTF, 'test-installed-app-id'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $schedules = [self::createStub(ScheduleInterface::class), self::createStub(ScheduleInterface::class)];

        $schedulesTransformer = self::createMock(SchedulesTransformerInterface::class);
        $schedulesTransformer->expects(self::once())->method('transform')
            ->with($data[ScheduleApiInterface::KEY_ITEMS])
            ->willReturn($schedules);

        $api = new ScheduleApi($requestSender, self::createStub(ScheduleTransformerInterface::class), $schedulesTransformer, new Token('test-api-token'));
        $actual = $api->getMultiple('test-installed-app-id');

        self::assertSame($schedules, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleCaches(): void
    {
        $data = [
            ScheduleApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $schedules = [self::createStub(ScheduleInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $schedulesTransformer = self::createMock(SchedulesTransformerInterface::class);
        $schedulesTransformer->expects(self::once())
            ->method('transform')
            ->with($data[ScheduleApiInterface::KEY_ITEMS])
            ->willReturn($schedules);

        $api = new ScheduleApi($requestSender, self::createStub(ScheduleTransformerInterface::class), $schedulesTransformer, new Token('test-api-token'));

        // Second call for the same installed app is served from the cache without hitting the API.
        self::assertSame($schedules, $api->getMultiple('test-installed-app-id'));
        self::assertSame($schedules, $api->getMultiple('test-installed-app-id'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleEncodesInstalledAppId(): void
    {
        $data = [
            ScheduleApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $schedules = [self::createStub(ScheduleInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(ScheduleApiInterface::API_URL_LIST_SPRINTF, rawurlencode('a/b c')),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $schedulesTransformer = self::createMock(SchedulesTransformerInterface::class);
        $schedulesTransformer->expects(self::once())->method('transform')
            ->with($data[ScheduleApiInterface::KEY_ITEMS])
            ->willReturn($schedules);

        $api = new ScheduleApi($requestSender, self::createStub(ScheduleTransformerInterface::class), $schedulesTransformer, new Token('test-api-token'));
        $actual = $api->getMultiple('a/b c');

        self::assertSame($schedules, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetMultipleSkipsCache(): void
    {
        $data = [
            ScheduleApiInterface::KEY_ITEMS => ['test-item-1'],
        ];

        $schedules = [self::createStub(ScheduleInterface::class)];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $schedulesTransformer = self::createMock(SchedulesTransformerInterface::class);
        $schedulesTransformer->expects(self::exactly(2))->method('transform')
            ->with($data[ScheduleApiInterface::KEY_ITEMS])
            ->willReturn($schedules);

        $api = new ScheduleApi($requestSender, self::createStub(ScheduleTransformerInterface::class), $schedulesTransformer, new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($schedules, $api->getMultiple('test-installed-app-id'));
        self::assertSame($schedules, $api->getMultiple('test-installed-app-id', true));
    }

    /**
     * @param mixed[] $data
     *
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([['test-items-key-missing'], false])]
    #[TestWith([[ScheduleApiInterface::KEY_ITEMS => 'test-not-array'], false])]
    #[TestWith([['test-items-key-missing'], true])]
    #[TestWith([[ScheduleApiInterface::KEY_ITEMS => 'test-not-array'], true])]
    public function testGetMultipleUnexpectedResponse(array $data, bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn($data);

        $api = new ScheduleApi($requestSender, self::createStub(ScheduleTransformerInterface::class), self::createStub(SchedulesTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ScheduleApiInterface::UNEXPECTED_RESPONSE_SPRINTF, ScheduleApiInterface::KEY_ITEMS));
        $api->getMultiple('test-installed-app-id', $skipCache);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByName(): void
    {
        $data = ['test-schedule-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(ScheduleApiInterface::API_URL_SPRINTF, 'test-installed-app-id', 'test-schedule-name'),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $schedule = self::createStub(ScheduleInterface::class);

        $scheduleTransformer = self::createMock(ScheduleTransformerInterface::class);
        $scheduleTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($schedule);

        $api = new ScheduleApi($requestSender, $scheduleTransformer, self::createStub(SchedulesTransformerInterface::class), new Token('test-api-token'));
        $actual = $api->getOneByName('test-installed-app-id', 'test-schedule-name');

        self::assertSame($schedule, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByNameCaches(): void
    {
        $data = ['test-schedule-data'];

        $schedule = self::createStub(ScheduleInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->willReturn($data);

        $scheduleTransformer = self::createMock(ScheduleTransformerInterface::class);
        $scheduleTransformer->expects(self::once())
            ->method('transform')
            ->with($data)
            ->willReturn($schedule);

        $api = new ScheduleApi($requestSender, $scheduleTransformer, self::createStub(SchedulesTransformerInterface::class), new Token('test-api-token'));

        // Second call for the same ids is served from the cache without hitting the API.
        self::assertSame($schedule, $api->getOneByName('test-installed-app-id', 'test-schedule-name'));
        self::assertSame($schedule, $api->getOneByName('test-installed-app-id', 'test-schedule-name'));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith(['a/b c', 'x/y z'])]
    #[TestWith(['../../installedapps', '../../schedules'])]
    public function testGetOneByNameEncodesIds(string $installedAppId, string $scheduleName): void
    {
        $data = ['test-schedule-data'];

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->with(
                sprintf(ScheduleApiInterface::API_URL_SPRINTF, rawurlencode($installedAppId), rawurlencode($scheduleName)),
                [],
                [
                    ApiInterface::HEADER_KEY_AUTHORIZATION => sprintf(TokenInterface::AUTHORIZATION_HEADER_VALUE_SPRINTF, 'test-api-token'),
                ]
            )
            ->willReturn($data);

        $schedule = self::createStub(ScheduleInterface::class);

        $scheduleTransformer = self::createMock(ScheduleTransformerInterface::class);
        $scheduleTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($schedule);

        $api = new ScheduleApi($requestSender, $scheduleTransformer, self::createStub(SchedulesTransformerInterface::class), new Token('test-api-token'));
        $actual = $api->getOneByName($installedAppId, $scheduleName);

        self::assertSame($schedule, $actual);
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    public function testGetOneByNameSkipsCache(): void
    {
        $data = ['test-schedule-data'];

        $schedule = self::createStub(ScheduleInterface::class);

        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))
            ->method('get')
            ->willReturn($data);

        $scheduleTransformer = self::createMock(ScheduleTransformerInterface::class);
        $scheduleTransformer->expects(self::exactly(2))->method('transform')
            ->with($data)
            ->willReturn($schedule);

        $api = new ScheduleApi($requestSender, $scheduleTransformer, self::createStub(SchedulesTransformerInterface::class), new Token('test-api-token'));

        // First call populates the cache; the second bypasses it and hits the API again.
        self::assertSame($schedule, $api->getOneByName('test-installed-app-id', 'test-schedule-name'));
        self::assertSame($schedule, $api->getOneByName('test-installed-app-id', 'test-schedule-name', true));
    }

    /**
     * @throws RequestExceptionInterface
     * @throws Exception
     */
    #[TestWith([false])]
    #[TestWith([true])]
    public function testGetOneByNameUnexpectedResponse(bool $skipCache): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')
            ->willReturn([]);

        $api = new ScheduleApi($requestSender, self::createStub(ScheduleTransformerInterface::class), self::createStub(SchedulesTransformerInterface::class), new Token('test-api-token'));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(ScheduleApiInterface::UNEXPECTED_RESPONSE);
        $api->getOneByName('test-installed-app-id', 'test-schedule-name', $skipCache);
    }
}
