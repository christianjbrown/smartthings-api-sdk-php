<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\StringConfig;
use ChristianBrown\SmartThings\Transformer\StringConfigTransformer;
use ChristianBrown\SmartThings\Transformer\StringConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(StringConfigTransformer::class)]
#[CoversClass(StringConfig::class)]
#[CoversClass(ValueReader::class)]
final class StringConfigTransformerTest extends TestCase
{
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new StringConfigTransformer(new ValueReader()))->transform([]);

        self::assertNull($actual->getValue());
    }

    public function testTransformReadsEveryField(): void
    {
        $actual = (new StringConfigTransformer(new ValueReader()))->transform([
            StringConfigTransformerInterface::KEY_VALUE => 'test-value',
        ]);

        self::assertSame('test-value', $actual->getValue());
    }
}
