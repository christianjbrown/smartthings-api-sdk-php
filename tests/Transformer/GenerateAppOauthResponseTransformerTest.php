<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AppOauthInterface;
use ChristianBrown\SmartThings\Model\GenerateAppOauthResponse;
use ChristianBrown\SmartThings\Transformer\AppOauthTransformerInterface;
use ChristianBrown\SmartThings\Transformer\GenerateAppOauthResponseTransformer;
use ChristianBrown\SmartThings\Transformer\GenerateAppOauthResponseTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(GenerateAppOauthResponse::class)]
#[CoversClass(GenerateAppOauthResponseTransformer::class)]
final class GenerateAppOauthResponseTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $appOauthTransformerModel = self::createStub(AppOauthInterface::class);
        $appOauthTransformer = self::createStub(AppOauthTransformerInterface::class);
        $appOauthTransformer->method('transform')->willReturn($appOauthTransformerModel);
        $data = [
            GenerateAppOauthResponseTransformerInterface::KEY_OAUTH_CLIENT_DETAILS => ['test-nested'],
            GenerateAppOauthResponseTransformerInterface::KEY_OAUTH_CLIENT_ID => 'test-oauth-client-id',
            GenerateAppOauthResponseTransformerInterface::KEY_OAUTH_CLIENT_SECRET => 'test-oauth-client-secret',
        ];

        $transformer = new GenerateAppOauthResponseTransformer($appOauthTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($appOauthTransformerModel, $actual->getOauthClientDetails());
        self::assertSame('test-oauth-client-id', $actual->getOauthClientId());
        self::assertSame('test-oauth-client-secret', $actual->getOauthClientSecret());
    }

    public function testTransformNestedOauthClientDetails(): void
    {
        $nested = self::createStub(AppOauthInterface::class);
        $nestedTransformer = self::createStub(AppOauthTransformerInterface::class);
        $nestedTransformer->method('transform')->willReturn($nested);

        $transformer = new GenerateAppOauthResponseTransformer($nestedTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getOauthClientDetails());
        self::assertNull($transformer->transform($base + [GenerateAppOauthResponseTransformerInterface::KEY_OAUTH_CLIENT_DETAILS => 'not-array'])->getOauthClientDetails());
        self::assertSame($nested, $transformer->transform($base + [GenerateAppOauthResponseTransformerInterface::KEY_OAUTH_CLIENT_DETAILS => ['test-nested']])->getOauthClientDetails());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new GenerateAppOauthResponseTransformer(self::createStub(AppOauthTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'oauthClientIdAbsent' => [[], 'getOauthClientId', null];
        yield 'oauthClientIdWrongType' => [[GenerateAppOauthResponseTransformerInterface::KEY_OAUTH_CLIENT_ID => 42], 'getOauthClientId', null];
        yield 'oauthClientIdValid' => [[GenerateAppOauthResponseTransformerInterface::KEY_OAUTH_CLIENT_ID => 'test-oauth-client-id'], 'getOauthClientId', 'test-oauth-client-id'];
        yield 'oauthClientSecretAbsent' => [[], 'getOauthClientSecret', null];
        yield 'oauthClientSecretWrongType' => [[GenerateAppOauthResponseTransformerInterface::KEY_OAUTH_CLIENT_SECRET => 42], 'getOauthClientSecret', null];
        yield 'oauthClientSecretValid' => [[GenerateAppOauthResponseTransformerInterface::KEY_OAUTH_CLIENT_SECRET => 'test-oauth-client-secret'], 'getOauthClientSecret', 'test-oauth-client-secret'];
    }
}
