<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\LocaleReference;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LocaleReference::class)]
final class LocaleReferenceTest extends TestCase
{
    public function test(): void
    {
        $reference = new LocaleReference('en');
        self::assertSame('en', $reference->getTag());

        self::assertSame($reference, $reference->setTag('ko'));
        self::assertSame('ko', $reference->getTag());
    }
}
