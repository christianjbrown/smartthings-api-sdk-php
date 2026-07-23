<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AppOauth;
use ChristianBrown\SmartThings\Transformer\AppOauthTransformer;
use ChristianBrown\SmartThings\Transformer\AppOauthTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AppOauth::class)]
#[CoversClass(AppOauthTransformer::class)]
final class AppOauthTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AppOauthTransformerInterface::KEY_CLIENT_NAME => 'test-client',
            AppOauthTransformerInterface::KEY_REDIRECT_URIS => ['https://example.test/a', 'https://example.test/b'],
            AppOauthTransformerInterface::KEY_SCOPE => ['r:devices:*', 'x:devices:*'],
        ];

        $transformer = new AppOauthTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-client', $actual->getClientName());
        self::assertSame(['https://example.test/a', 'https://example.test/b'], $actual->getRedirectUris());
        self::assertSame(['r:devices:*', 'x:devices:*'], $actual->getScope());
    }

    public function testTransformAllAbsent(): void
    {
        $transformer = new AppOauthTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getClientName());
        self::assertSame([], $actual->getRedirectUris());
        self::assertSame([], $actual->getScope());
    }

    public function testTransformClientNameWrongType(): void
    {
        $transformer = new AppOauthTransformer();

        $actual = $transformer->transform([AppOauthTransformerInterface::KEY_CLIENT_NAME => 42]);

        self::assertNull($actual->getClientName());
    }

    public function testTransformRedirectUrisFiltersNonStrings(): void
    {
        $transformer = new AppOauthTransformer();

        $actual = $transformer->transform([AppOauthTransformerInterface::KEY_REDIRECT_URIS => [1, 'https://example.test/x', true, 'https://example.test/y']]);

        self::assertSame(['https://example.test/x', 'https://example.test/y'], $actual->getRedirectUris());
    }

    public function testTransformRedirectUrisNotArray(): void
    {
        $transformer = new AppOauthTransformer();

        $actual = $transformer->transform([AppOauthTransformerInterface::KEY_REDIRECT_URIS => 'not-an-array']);

        self::assertSame([], $actual->getRedirectUris());
    }

    public function testTransformScopeFiltersNonStrings(): void
    {
        $transformer = new AppOauthTransformer();

        $actual = $transformer->transform([AppOauthTransformerInterface::KEY_SCOPE => [1, 'r:devices:*', null, 'x:devices:*']]);

        self::assertSame(['r:devices:*', 'x:devices:*'], $actual->getScope());
    }

    public function testTransformScopeNotArray(): void
    {
        $transformer = new AppOauthTransformer();

        $actual = $transformer->transform([AppOauthTransformerInterface::KEY_SCOPE => 'not-an-array']);

        self::assertSame([], $actual->getScope());
    }
}
