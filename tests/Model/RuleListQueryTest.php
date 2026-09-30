<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\RuleListQuery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RuleListQuery::class)]
final class RuleListQueryTest extends TestCase
{
    public function testDefaultsToNoParameters(): void
    {
        $query = new RuleListQuery();

        self::assertNull($query->getIncludeAllParents());
        self::assertNull($query->getMax());
        self::assertNull($query->getOffset());
        self::assertSame([
            \ChristianBrown\SmartThings\Model\RuleListQueryInterface::KEY_INCLUDE_ALL_PARENTS => null,
            \ChristianBrown\SmartThings\Model\RuleListQueryInterface::KEY_MAX => null,
            \ChristianBrown\SmartThings\Model\RuleListQueryInterface::KEY_OFFSET => null,
        ], $query->getParameters());
    }

    public function testStoresEveryParameter(): void
    {
        $query = new RuleListQuery();
        self::assertSame($query, $query->setIncludeAllParents(true));
        self::assertSame($query, $query->setMax(7));
        self::assertSame($query, $query->setOffset(7));
        self::assertTrue($query->getIncludeAllParents());
        self::assertSame(7, $query->getMax());
        self::assertSame(7, $query->getOffset());
        self::assertSame([
            \ChristianBrown\SmartThings\Model\RuleListQueryInterface::KEY_INCLUDE_ALL_PARENTS => true,
            \ChristianBrown\SmartThings\Model\RuleListQueryInterface::KEY_MAX => 7,
            \ChristianBrown\SmartThings\Model\RuleListQueryInterface::KEY_OFFSET => 7,
        ], $query->getParameters());
    }
}
