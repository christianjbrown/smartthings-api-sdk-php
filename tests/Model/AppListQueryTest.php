<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\AppListQuery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AppListQuery::class)]
final class AppListQueryTest extends TestCase
{
    public function testDefaultsToNoParameters(): void
    {
        $query = new AppListQuery();

        self::assertNull($query->getAccountId());
        self::assertNull($query->getAppType());
        self::assertNull($query->getClassification());
        self::assertNull($query->getTag());
        self::assertSame([
            \ChristianBrown\SmartThings\Model\AppListQueryInterface::KEY_ACCOUNT_ID => null,
            \ChristianBrown\SmartThings\Model\AppListQueryInterface::KEY_APP_TYPE => null,
            \ChristianBrown\SmartThings\Model\AppListQueryInterface::KEY_CLASSIFICATION => null,
            \ChristianBrown\SmartThings\Model\AppListQueryInterface::KEY_TAG => null,
        ], $query->getParameters());
    }

    public function testStoresEveryParameter(): void
    {
        $query = new AppListQuery();
        self::assertSame($query, $query->setAccountId('test-accountId'));
        self::assertSame($query, $query->setAppType('test-appType'));
        self::assertSame($query, $query->setClassification('test-classification'));
        self::assertSame($query, $query->setTag('test-tag'));
        self::assertSame('test-accountId', $query->getAccountId());
        self::assertSame('test-appType', $query->getAppType());
        self::assertSame('test-classification', $query->getClassification());
        self::assertSame('test-tag', $query->getTag());
        self::assertSame([
            \ChristianBrown\SmartThings\Model\AppListQueryInterface::KEY_ACCOUNT_ID => 'test-accountId',
            \ChristianBrown\SmartThings\Model\AppListQueryInterface::KEY_APP_TYPE => 'test-appType',
            \ChristianBrown\SmartThings\Model\AppListQueryInterface::KEY_CLASSIFICATION => 'test-classification',
            \ChristianBrown\SmartThings\Model\AppListQueryInterface::KEY_TAG => 'test-tag',
        ], $query->getParameters());
    }
}
