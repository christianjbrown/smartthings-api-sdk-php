<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\Localization;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Localization::class)]
final class LocalizationTest extends TestCase
{
    public function test(): void
    {
        $localization = new Localization('fr');
        self::assertSame('fr', $localization->getTag());
        self::assertNull($localization->getDescription());
        self::assertNull($localization->getLabel());

        self::assertSame($localization, $localization->setTag('ko'));
        self::assertSame($localization, $localization->setDescription('Sensibilité au mouvement'));
        self::assertSame($localization, $localization->setLabel('Sensibilité au mouvement'));

        self::assertSame('ko', $localization->getTag());
        self::assertSame('Sensibilité au mouvement', $localization->getDescription());
        self::assertSame('Sensibilité au mouvement', $localization->getLabel());
    }
}
