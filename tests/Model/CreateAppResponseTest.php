<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\AppInterface;
use ChristianBrown\SmartThings\Model\CreateAppResponse;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CreateAppResponse::class)]
final class CreateAppResponseTest extends TestCase
{
    public function test(): void
    {
        $app = self::createStub(AppInterface::class);

        $model = new CreateAppResponse();
        self::assertNull($model->getApp());
        self::assertNull($model->getOauthClientId());
        self::assertNull($model->getOauthClientSecret());

        self::assertSame($model, $model->setApp($app));
        self::assertSame($model, $model->setOauthClientId('test-other'));
        self::assertSame($model, $model->setOauthClientSecret('test-other'));

        self::assertSame($app, $model->getApp());
        self::assertSame('test-other', $model->getOauthClientId());
        self::assertSame('test-other', $model->getOauthClientSecret());
    }
}
