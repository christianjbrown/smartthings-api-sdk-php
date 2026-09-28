<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AppInterface;
use ChristianBrown\SmartThings\Model\CreateAppResponse;
use ChristianBrown\SmartThings\Transformer\AppTransformerInterface;
use ChristianBrown\SmartThings\Transformer\CreateAppResponseTransformer;
use ChristianBrown\SmartThings\Transformer\CreateAppResponseTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreateAppResponse::class)]
#[CoversClass(CreateAppResponseTransformer::class)]
final class CreateAppResponseTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $appTransformerModel = self::createStub(AppInterface::class);
        $appTransformer = self::createStub(AppTransformerInterface::class);
        $appTransformer->method('transform')->willReturn($appTransformerModel);
        $data = [
            CreateAppResponseTransformerInterface::KEY_APP => ['test-nested'],
            CreateAppResponseTransformerInterface::KEY_OAUTH_CLIENT_ID => 'test-oauth-client-id',
            CreateAppResponseTransformerInterface::KEY_OAUTH_CLIENT_SECRET => 'test-oauth-client-secret',
        ];

        $transformer = new CreateAppResponseTransformer($appTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($appTransformerModel, $actual->getApp());
        self::assertSame('test-oauth-client-id', $actual->getOauthClientId());
        self::assertSame('test-oauth-client-secret', $actual->getOauthClientSecret());
    }

    public function testTransformNestedApp(): void
    {
        $nested = self::createStub(AppInterface::class);
        $nestedTransformer = self::createStub(AppTransformerInterface::class);
        $nestedTransformer->method('transform')->willReturn($nested);

        $transformer = new CreateAppResponseTransformer($nestedTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getApp());
        self::assertNull($transformer->transform($base + [CreateAppResponseTransformerInterface::KEY_APP => 'not-array'])->getApp());
        self::assertSame($nested, $transformer->transform($base + [CreateAppResponseTransformerInterface::KEY_APP => ['test-nested']])->getApp());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new CreateAppResponseTransformer(self::createStub(AppTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'oauthClientIdAbsent' => [[], 'getOauthClientId', null];
        yield 'oauthClientIdWrongType' => [[CreateAppResponseTransformerInterface::KEY_OAUTH_CLIENT_ID => 42], 'getOauthClientId', null];
        yield 'oauthClientIdValid' => [[CreateAppResponseTransformerInterface::KEY_OAUTH_CLIENT_ID => 'test-oauth-client-id'], 'getOauthClientId', 'test-oauth-client-id'];
        yield 'oauthClientSecretAbsent' => [[], 'getOauthClientSecret', null];
        yield 'oauthClientSecretWrongType' => [[CreateAppResponseTransformerInterface::KEY_OAUTH_CLIENT_SECRET => 42], 'getOauthClientSecret', null];
        yield 'oauthClientSecretValid' => [[CreateAppResponseTransformerInterface::KEY_OAUTH_CLIENT_SECRET => 'test-oauth-client-secret'], 'getOauthClientSecret', 'test-oauth-client-secret'];
    }
}
