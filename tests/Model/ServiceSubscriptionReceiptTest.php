<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\ServiceSubscriptionReceipt;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceSubscriptionReceipt::class)]
final class ServiceSubscriptionReceiptTest extends TestCase
{
    public function test(): void
    {
        $model = new ServiceSubscriptionReceipt('test-location-id');
        self::assertSame('test-location-id', $model->getLocationId());
        self::assertNull($model->getSubscriptionId());

        self::assertSame($model, $model->setLocationId('test-other'));
        self::assertSame($model, $model->setSubscriptionId('test-other'));

        self::assertSame('test-other', $model->getLocationId());
        self::assertSame('test-other', $model->getSubscriptionId());
    }
}
