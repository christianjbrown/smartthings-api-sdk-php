<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\SmartThings\Api\ApiHostInterface;
use ChristianBrown\SmartThings\Api\HostOverridingJsonApiRequestSender;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(HostOverridingJsonApiRequestSender::class)]
final class HostOverridingJsonApiRequestSenderTest extends TestCase
{
    public function testDelete(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('delete')
            ->with('https://staging.example.test/v1/devices/', ['a' => 'b'], ['c' => 'd'])
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->delete('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd']));
    }

    public function testGet(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('get')
            ->with('https://staging.example.test/v1/devices/', ['a' => 'b'], ['c' => 'd'])
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->get('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd']));
    }

    public function testPatch(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('patch')
            ->with('https://staging.example.test/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f'])
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->patch('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f']));
    }

    public function testPatchForm(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('patchForm')
            ->with('https://staging.example.test/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f'])
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->patchForm('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f']));
    }

    public function testPost(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('post')
            ->with('https://staging.example.test/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f'])
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->post('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f']));
    }

    public function testPostForm(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('postForm')
            ->with('https://staging.example.test/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f'])
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->postForm('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f']));
    }

    public function testPut(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('put')
            ->with('https://staging.example.test/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f'])
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->put('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f']));
    }

    public function testPutForm(): void
    {
        $requestSender = self::createMock(JsonApiRequestSenderInterface::class);
        $requestSender->expects(self::once())
            ->method('putForm')
            ->with('https://staging.example.test/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f'])
            ->willReturn(['result' => true]);

        $sender = self::createSender($requestSender);

        self::assertSame(['result' => true], $sender->putForm('https://api.smartthings.com/v1/devices/', ['a' => 'b'], ['c' => 'd'], ['e' => 'f']));
    }

    private static function createSender(JsonApiRequestSenderInterface $requestSender): HostOverridingJsonApiRequestSender
    {
        $apiHost = self::createStub(ApiHostInterface::class);
        $apiHost->method('getBaseUrl')->willReturn('https://staging.example.test');

        return new HostOverridingJsonApiRequestSender($requestSender, $apiHost);
    }
}
