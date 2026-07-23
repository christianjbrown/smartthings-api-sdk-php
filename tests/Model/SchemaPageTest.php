<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\SchemaPage;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchemaPage::class)]
final class SchemaPageTest extends TestCase
{
    public function test(): void
    {
        $page = new SchemaPage('requiresLogin');
        self::assertSame('requiresLogin', $page->getPageType());
        self::assertNull($page->getAppName());
        self::assertNull($page->getIsaId());
        self::assertNull($page->getLocationId());
        self::assertNull($page->getOAuthLink());
        self::assertNull($page->getPartnerName());

        self::assertSame($page, $page->setPageType('loggedIn'));
        self::assertSame($page, $page->setAppName('Lifx (Connect)'));
        self::assertSame($page, $page->setIsaId('test-isa-id'));
        self::assertSame($page, $page->setLocationId('test-location-id'));
        self::assertSame($page, $page->setOAuthLink('https://example.com/oauth'));
        self::assertSame($page, $page->setPartnerName('LIFX Inc.'));

        self::assertSame('loggedIn', $page->getPageType());
        self::assertSame('Lifx (Connect)', $page->getAppName());
        self::assertSame('test-isa-id', $page->getIsaId());
        self::assertSame('test-location-id', $page->getLocationId());
        self::assertSame('https://example.com/oauth', $page->getOAuthLink());
        self::assertSame('LIFX Inc.', $page->getPartnerName());
    }
}
