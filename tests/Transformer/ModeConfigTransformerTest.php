<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ModeConfig;
use ChristianBrown\SmartThings\Transformer\ModeConfigTransformer;
use ChristianBrown\SmartThings\Transformer\ModeConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ModeConfigTransformer::class)]
#[CoversClass(ModeConfig::class)]
#[CoversClass(ValueReader::class)]
final class ModeConfigTransformerTest extends TestCase
{
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new ModeConfigTransformer(new ValueReader()))->transform([]);

        self::assertNull($actual->getModeId());
    }

    public function testTransformReadsEveryField(): void
    {
        $actual = (new ModeConfigTransformer(new ValueReader()))->transform([
            ModeConfigTransformerInterface::KEY_MODE_ID => 'test-modeId',
        ]);

        self::assertSame('test-modeId', $actual->getModeId());
    }
}
