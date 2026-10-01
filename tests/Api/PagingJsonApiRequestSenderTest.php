<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\ApiClient\Multipart\MultipartPartInterface;
use ChristianBrown\SmartThings\Api\PagingJsonApiRequestSender;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PagingJsonApiRequestSender::class)]
final class PagingJsonApiRequestSenderTest extends TestCase
{
    public function testDelete(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('delete')
            ->with('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'])
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->delete('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd']));
    }

    public function testGet(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'])
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->get('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd']));
    }

    public function testGetFollowsTheNextLinksAndMergesTheItems(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(3))->method('get')
            ->willReturnMap([
                ['https://api.smartthings.com/v1/devices', ['a' => 'b'], ['c' => 'd'], ['items' => [1, 2], '_links' => ['next' => ['href' => 'https://api.smartthings.com/v1/devices?page=2']], 'extra' => 'kept']],
                ['https://api.smartthings.com/v1/devices?page=2', [], ['c' => 'd'], ['items' => [3], '_links' => ['next' => ['href' => 'https://api.smartthings.com/v1/devices?page=3'], 'previous' => ['href' => 'x']]]],
                ['https://api.smartthings.com/v1/devices?page=3', [], ['c' => 'd'], ['items' => [4], '_links' => []]],
            ]);

        $response = self::createSender($requestSender)->get('https://api.smartthings.com/v1/devices', ['a' => 'b'], ['c' => 'd']);

        self::assertSame(['items' => [1, 2, 3, 4], 'extra' => 'kept', '_links' => []], $response);
    }

    /**
     * @param array<array-key, mixed> $response
     */
    #[DataProvider('provideGetLeavesResponsesWithoutANextPageAloneCases')]
    public function testGetLeavesResponsesWithoutANextPageAlone(array $response): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())->method('get')->willReturn($response);

        self::assertSame($response, self::createSender($requestSender)->get('https://api.smartthings.com/v1/devices'));
    }

    /**
     * @return iterable<string, array{array<array-key, mixed>}>
     */
    public static function provideGetLeavesResponsesWithoutANextPageAloneCases(): iterable
    {
        yield 'no items' => [['_links' => ['next' => ['href' => 'https://api.smartthings.com/v1/next']]]];
        yield 'items not a list' => [['items' => 'x', '_links' => ['next' => ['href' => 'https://api.smartthings.com/v1/next']]]];
        yield 'no links' => [['items' => [1]]];
        yield 'links not an array' => [['items' => [1], '_links' => 'x']];
        yield 'next not an array' => [['items' => [1], '_links' => ['next' => 'x']]];
        yield 'href not a string' => [['items' => [1], '_links' => ['next' => ['href' => 5]]]];
        yield 'empty href' => [['items' => [1], '_links' => ['next' => ['href' => '']]]];
    }

    public function testGetStopsAtTheConfiguredNumberOfPages(): void
    {
        $page = ['items' => [1], '_links' => ['next' => ['href' => 'https://api.smartthings.com/v1/next']]];
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(3))->method('get')->willReturn($page);

        $response = self::createSender($requestSender)->get('https://api.smartthings.com/v1/devices');

        self::assertSame([1, 1, 1], $response['items']);
    }

    public function testGetStopsWhenTheNextPageHasNoItems(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnOnConsecutiveCalls(
                ['items' => [1], '_links' => ['next' => ['href' => 'https://api.smartthings.com/v1/next']]],
                ['other' => true]
            );

        self::assertSame(['items' => [1], '_links' => ['next' => ['href' => 'https://api.smartthings.com/v1/next']]], self::createSender($requestSender)->get('https://api.smartthings.com/v1/devices'));
    }

    public function testGetStopsWhenTheNextPageItemsAreNotAList(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::exactly(2))->method('get')
            ->willReturnOnConsecutiveCalls(
                ['items' => [1], '_links' => ['next' => ['href' => 'https://api.smartthings.com/v1/next']]],
                ['items' => 'nope']
            );

        self::assertSame([1], self::createSender($requestSender)->get('https://api.smartthings.com/v1/devices')['items']);
    }

    public function testPatch(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('patch')
            ->with('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f'])
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->patch('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f']));
    }

    public function testPatchForm(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('patchForm')
            ->with('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f'])
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->patchForm('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f']));
    }

    public function testPatchMultipart(): void
    {
        $parts = [self::createStub(MultipartPartInterface::class)];
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('patchMultipart')
            ->with('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], $parts)
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->patchMultipart('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], $parts));
    }

    public function testPost(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('post')
            ->with('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f'])
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->post('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f']));
    }

    public function testPostForm(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('postForm')
            ->with('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f'])
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->postForm('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f']));
    }

    public function testPostMultipart(): void
    {
        $parts = [self::createStub(MultipartPartInterface::class)];
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('postMultipart')
            ->with('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], $parts)
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->postMultipart('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], $parts));
    }

    public function testPut(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('put')
            ->with('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f'])
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->put('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f']));
    }

    public function testPutForm(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('putForm')
            ->with('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f'])
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->putForm('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f']));
    }

    public function testPutMultipart(): void
    {
        $parts = [self::createStub(MultipartPartInterface::class)];
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('putMultipart')
            ->with('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], $parts)
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->putMultipart('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], $parts));
    }

    private static function createSender(JsonApiRequestSenderInterface $requestSender): PagingJsonApiRequestSender
    {
        return new PagingJsonApiRequestSender($requestSender, 3);
    }
}
