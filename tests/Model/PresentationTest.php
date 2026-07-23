<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\Presentation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Presentation::class)]
final class PresentationTest extends TestCase
{
    public function test(): void
    {
        $presentation = new Presentation('test-presentation-id');
        self::assertSame('test-presentation-id', $presentation->getPresentationId());
        self::assertNull($presentation->getManufacturerName());
        self::assertNull($presentation->getType());

        self::assertSame($presentation, $presentation->setPresentationId('test-new-presentation-id'));
        self::assertSame($presentation, $presentation->setManufacturerName('test-manufacturer'));
        self::assertSame($presentation, $presentation->setType('profile'));

        self::assertSame('test-new-presentation-id', $presentation->getPresentationId());
        self::assertSame('test-manufacturer', $presentation->getManufacturerName());
        self::assertSame('profile', $presentation->getType());
    }
}
