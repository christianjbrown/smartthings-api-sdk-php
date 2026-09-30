<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\PreferenceListQuery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PreferenceListQuery::class)]
final class PreferenceListQueryTest extends TestCase
{
    public function testDefaultsToNoParameters(): void
    {
        $query = new PreferenceListQuery();

        self::assertNull($query->getNamespace());
        self::assertNull($query->getPageSize());
        self::assertNull($query->getStartKey());
        self::assertSame([
            \ChristianBrown\SmartThings\Model\PreferenceListQueryInterface::KEY_NAMESPACE => null,
            \ChristianBrown\SmartThings\Model\PreferenceListQueryInterface::KEY_PAGE_SIZE => null,
            \ChristianBrown\SmartThings\Model\PreferenceListQueryInterface::KEY_START_KEY => null,
        ], $query->getParameters());
    }

    public function testStoresEveryParameter(): void
    {
        $query = new PreferenceListQuery();
        self::assertSame($query, $query->setNamespace('test-namespace'));
        self::assertSame($query, $query->setPageSize(7));
        self::assertSame($query, $query->setStartKey('test-startKey'));
        self::assertSame('test-namespace', $query->getNamespace());
        self::assertSame(7, $query->getPageSize());
        self::assertSame('test-startKey', $query->getStartKey());
        self::assertSame([
            \ChristianBrown\SmartThings\Model\PreferenceListQueryInterface::KEY_NAMESPACE => 'test-namespace',
            \ChristianBrown\SmartThings\Model\PreferenceListQueryInterface::KEY_PAGE_SIZE => 7,
            \ChristianBrown\SmartThings\Model\PreferenceListQueryInterface::KEY_START_KEY => 'test-startKey',
        ], $query->getParameters());
    }
}
