<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\CapabilityPresentation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CapabilityPresentation::class)]
final class CapabilityPresentationTest extends TestCase
{
    public function test(): void
    {
        $presentation = new CapabilityPresentation('switch');
        self::assertSame('switch', $presentation->getId());
        self::assertNull($presentation->getVersion());

        self::assertSame($presentation, $presentation->setId('switchLevel'));
        self::assertSame($presentation, $presentation->setVersion(1));

        self::assertSame('switchLevel', $presentation->getId());
        self::assertSame(1, $presentation->getVersion());
    }
}
