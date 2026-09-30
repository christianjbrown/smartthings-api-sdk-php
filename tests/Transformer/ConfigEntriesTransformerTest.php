<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ConfigEntryInterface;
use ChristianBrown\SmartThings\Transformer\ConfigEntriesTransformer;
use ChristianBrown\SmartThings\Transformer\ConfigEntryTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConfigEntriesTransformer::class)]
final class ConfigEntriesTransformerTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testTransformKeepsTheNamesAndTransformsEachEntry(): void
    {
        $entry = self::createStub(ConfigEntryInterface::class);
        $entryTransformer = self::createMock(ConfigEntryTransformerInterface::class);
        $entryTransformer->expects(self::once())->method('transform')
            ->with(['valueType' => 'STRING'])
            ->willReturn($entry);

        $actual = (new ConfigEntriesTransformer($entryTransformer))->transform([
            'color' => [['valueType' => 'STRING'], 'skipped'],
            'skipped' => 'not-a-list',
        ]);

        self::assertSame(['color' => [$entry]], $actual);
    }
}
