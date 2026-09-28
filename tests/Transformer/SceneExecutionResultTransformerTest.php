<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\SceneExecutionResult;
use ChristianBrown\SmartThings\Transformer\SceneExecutionResultTransformer;
use ChristianBrown\SmartThings\Transformer\SceneExecutionResultTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(SceneExecutionResult::class)]
#[CoversClass(SceneExecutionResultTransformer::class)]
final class SceneExecutionResultTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SceneExecutionResultTransformerInterface::KEY_STATUS => 'success',
        ];

        $transformer = new SceneExecutionResultTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('success', $actual->getStatus());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[SceneExecutionResultTransformerInterface::KEY_STATUS => 42]])]
    public function testTransformStatusMissingOrWrongType(array $data): void
    {
        $transformer = new SceneExecutionResultTransformer();

        $actual = $transformer->transform($data);

        self::assertNull($actual->getStatus());
    }
}
