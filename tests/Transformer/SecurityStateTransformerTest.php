<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\SecurityState;
use ChristianBrown\SmartThings\Transformer\SecurityStateTransformer;
use ChristianBrown\SmartThings\Transformer\SecurityStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SecurityStateTransformer::class)]
#[CoversClass(SecurityState::class)]
#[CoversClass(ValueReader::class)]
final class SecurityStateTransformerTest extends TestCase
{
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new SecurityStateTransformer(new ValueReader()))->transform([]);

        self::assertNull($actual->getArmState());
        self::assertNull($actual->getMonitoring());
    }

    public function testTransformReadsEveryField(): void
    {
        $actual = (new SecurityStateTransformer(new ValueReader()))->transform([
            SecurityStateTransformerInterface::KEY_ARM_STATE => 'test-armState',
            SecurityStateTransformerInterface::KEY_MONITORING => true,
        ]);

        self::assertSame('test-armState', $actual->getArmState());
        self::assertTrue($actual->getMonitoring());
    }
}
