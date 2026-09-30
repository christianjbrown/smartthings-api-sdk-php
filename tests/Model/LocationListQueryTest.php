<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\LocationListQuery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LocationListQuery::class)]
final class LocationListQueryTest extends TestCase
{
    public function testDefaultsToNoParameters(): void
    {
        $query = new LocationListQuery();

        self::assertNull($query->getAllowed());
        self::assertNull($query->getLimit());
        self::assertNull($query->getPage());
        self::assertSame([
            \ChristianBrown\SmartThings\Model\LocationListQueryInterface::KEY_ALLOWED => null,
            \ChristianBrown\SmartThings\Model\LocationListQueryInterface::KEY_LIMIT => null,
            \ChristianBrown\SmartThings\Model\LocationListQueryInterface::KEY_PAGE => null,
        ], $query->getParameters());
    }

    public function testStoresEveryParameter(): void
    {
        $query = new LocationListQuery();
        self::assertSame($query, $query->setAllowed(true));
        self::assertSame($query, $query->setLimit(7));
        self::assertSame($query, $query->setPage('test-page'));
        self::assertTrue($query->getAllowed());
        self::assertSame(7, $query->getLimit());
        self::assertSame('test-page', $query->getPage());
        self::assertSame([
            \ChristianBrown\SmartThings\Model\LocationListQueryInterface::KEY_ALLOWED => true,
            \ChristianBrown\SmartThings\Model\LocationListQueryInterface::KEY_LIMIT => 7,
            \ChristianBrown\SmartThings\Model\LocationListQueryInterface::KEY_PAGE => 'test-page',
        ], $query->getParameters());
    }
}
