<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\PermissionConfig;
use ChristianBrown\SmartThings\Transformer\PermissionConfigTransformer;
use ChristianBrown\SmartThings\Transformer\PermissionConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PermissionConfigTransformer::class)]
#[CoversClass(PermissionConfig::class)]
#[CoversClass(ValueReader::class)]
final class PermissionConfigTransformerTest extends TestCase
{
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new PermissionConfigTransformer(new ValueReader()))->transform([]);

        self::assertSame([], $actual->getPermissions());
    }

    public function testTransformReadsEveryField(): void
    {
        $actual = (new PermissionConfigTransformer(new ValueReader()))->transform([
            PermissionConfigTransformerInterface::KEY_PERMISSIONS => ['test-permissions-1', 'test-permissions-2'],
        ]);

        self::assertSame(['test-permissions-1', 'test-permissions-2'], $actual->getPermissions());
    }
}
