<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Api;

use ChristianBrown\SmartThings\Api\RequestUrlBuilder;
use ChristianBrown\SmartThings\Model\QueryParametersInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(RequestUrlBuilder::class)]
final class RequestUrlBuilderTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testExplicitParametersWinOverTheQueryObject(): void
    {
        $query = self::createStub(QueryParametersInterface::class);
        $query->method('getParameters')->willReturn(['a' => 'from-query', 'b' => 'only-query', 'c' => null]);

        $url = (new RequestUrlBuilder())->build('https://example.test/a', ['a' => 'explicit', 'c' => 'set'], $query);

        self::assertSame('https://example.test/a?a=explicit&b=only-query&c=set', $url);
    }

    public function testFormatsScalarsBooleansAndLists(): void
    {
        $url = (new RequestUrlBuilder())->build('https://example.test/a', ['name' => 'a b', 'flag' => true, 'off' => false, 'count' => 3, 'many' => ['x', 'y', 'z']]);

        self::assertSame('https://example.test/a?name=a%20b&flag=true&off=false&count=3&many=x&many=y&many=z', $url);
    }

    public function testLeavesOutEmptyLists(): void
    {
        self::assertSame('https://example.test/a', (new RequestUrlBuilder())->build('https://example.test/a', ['x' => []]));
    }

    public function testLeavesOutNullParameters(): void
    {
        self::assertSame('https://example.test/a', (new RequestUrlBuilder())->build('https://example.test/a', ['x' => null]));
    }

    public function testReturnsTheBaseUrlWhenThereAreNoParameters(): void
    {
        self::assertSame('https://example.test/a', (new RequestUrlBuilder())->build('https://example.test/a'));
    }
}
