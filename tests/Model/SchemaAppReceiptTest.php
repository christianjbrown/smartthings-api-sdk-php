<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\SchemaAppReceipt;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchemaAppReceipt::class)]
final class SchemaAppReceiptTest extends TestCase
{
    public function test(): void
    {
        $model = new SchemaAppReceipt();
        self::assertNull($model->getEndpointAppId());
        self::assertNull($model->getStClientId());
        self::assertNull($model->getStClientSecret());

        self::assertSame($model, $model->setEndpointAppId('test-other'));
        self::assertSame($model, $model->setStClientId('test-other'));
        self::assertSame($model, $model->setStClientSecret('test-other'));

        self::assertSame('test-other', $model->getEndpointAppId());
        self::assertSame('test-other', $model->getStClientId());
        self::assertSame('test-other', $model->getStClientSecret());
    }
}
