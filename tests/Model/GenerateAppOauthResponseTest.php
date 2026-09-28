<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Model;

use ChristianBrown\SmartThings\Model\AppOauthInterface;
use ChristianBrown\SmartThings\Model\GenerateAppOauthResponse;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(GenerateAppOauthResponse::class)]
final class GenerateAppOauthResponseTest extends TestCase
{
    public function test(): void
    {
        $oauthClientDetails = self::createStub(AppOauthInterface::class);

        $model = new GenerateAppOauthResponse();
        self::assertNull($model->getOauthClientDetails());
        self::assertNull($model->getOauthClientId());
        self::assertNull($model->getOauthClientSecret());

        self::assertSame($model, $model->setOauthClientDetails($oauthClientDetails));
        self::assertSame($model, $model->setOauthClientId('test-other'));
        self::assertSame($model, $model->setOauthClientSecret('test-other'));

        self::assertSame($oauthClientDetails, $model->getOauthClientDetails());
        self::assertSame('test-other', $model->getOauthClientId());
        self::assertSame('test-other', $model->getOauthClientSecret());
    }
}
