<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\MessageConfig;
use ChristianBrown\SmartThings\Transformer\MessageConfigTransformer;
use ChristianBrown\SmartThings\Transformer\MessageConfigTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ValueReader;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MessageConfigTransformer::class)]
#[CoversClass(MessageConfig::class)]
#[CoversClass(ValueReader::class)]
final class MessageConfigTransformerTest extends TestCase
{
    public function testTransformLeavesMissingFieldsUnset(): void
    {
        $actual = (new MessageConfigTransformer(new ValueReader()))->transform([]);

        self::assertNull($actual->getMessageGroupKey());
    }

    public function testTransformReadsEveryField(): void
    {
        $actual = (new MessageConfigTransformer(new ValueReader()))->transform([
            MessageConfigTransformerInterface::KEY_MESSAGE_GROUP_KEY => 'test-messageGroupKey',
        ]);

        self::assertSame('test-messageGroupKey', $actual->getMessageGroupKey());
    }
}
