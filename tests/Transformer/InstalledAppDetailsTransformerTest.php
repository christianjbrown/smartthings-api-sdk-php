<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\InstalledAppDetails;
use ChristianBrown\SmartThings\Model\InstalledAppIconImageInterface;
use ChristianBrown\SmartThings\Model\InstalledAppUiInterface;
use ChristianBrown\SmartThings\Model\NoticeInterface;
use ChristianBrown\SmartThings\Model\OwnerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppIconImageTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppUiTransformerInterface;
use ChristianBrown\SmartThings\Transformer\NoticeTransformerInterface;
use ChristianBrown\SmartThings\Transformer\OwnerTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(InstalledAppDetails::class)]
#[CoversClass(InstalledAppDetailsTransformer::class)]
final class InstalledAppDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $ownerModel = self::createStub(OwnerInterface::class);
        $ownerTransformer = self::createStub(OwnerTransformerInterface::class);
        $ownerTransformer->method('transform')->willReturn($ownerModel);
        $noticeModel = self::createStub(NoticeInterface::class);
        $noticeTransformer = self::createStub(NoticeTransformerInterface::class);
        $noticeTransformer->method('transform')->willReturn($noticeModel);
        $installedAppUiModel = self::createStub(InstalledAppUiInterface::class);
        $installedAppUiTransformer = self::createStub(InstalledAppUiTransformerInterface::class);
        $installedAppUiTransformer->method('transform')->willReturn($installedAppUiModel);
        $installedAppIconImageModel = self::createStub(InstalledAppIconImageInterface::class);
        $installedAppIconImageTransformer = self::createStub(InstalledAppIconImageTransformerInterface::class);
        $installedAppIconImageTransformer->method('transform')->willReturn($installedAppIconImageModel);
        $data = [
            InstalledAppDetailsTransformerInterface::KEY_OWNER => ['test-nested'],
            InstalledAppDetailsTransformerInterface::KEY_NOTICES => [['test-nested']],
            InstalledAppDetailsTransformerInterface::KEY_UI => ['test-nested'],
            InstalledAppDetailsTransformerInterface::KEY_ICON_IMAGE => ['test-nested'],
        ];

        $transformer = new InstalledAppDetailsTransformer($ownerTransformer, $noticeTransformer, $installedAppUiTransformer, $installedAppIconImageTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($ownerModel, $actual->getOwner());
        self::assertSame([$noticeModel], $actual->getNotices());
        self::assertSame($installedAppUiModel, $actual->getUi());
        self::assertSame($installedAppIconImageModel, $actual->getIconImage());
    }

    public function testTransformIconImage(): void
    {
        $ownerModel = self::createStub(OwnerInterface::class);
        $ownerTransformer = self::createStub(OwnerTransformerInterface::class);
        $ownerTransformer->method('transform')->willReturn($ownerModel);
        $noticeModel = self::createStub(NoticeInterface::class);
        $noticeTransformer = self::createStub(NoticeTransformerInterface::class);
        $noticeTransformer->method('transform')->willReturn($noticeModel);
        $installedAppUiModel = self::createStub(InstalledAppUiInterface::class);
        $installedAppUiTransformer = self::createStub(InstalledAppUiTransformerInterface::class);
        $installedAppUiTransformer->method('transform')->willReturn($installedAppUiModel);
        $installedAppIconImageModel = self::createStub(InstalledAppIconImageInterface::class);
        $installedAppIconImageTransformer = self::createStub(InstalledAppIconImageTransformerInterface::class);
        $installedAppIconImageTransformer->method('transform')->willReturn($installedAppIconImageModel);
        $transformer = new InstalledAppDetailsTransformer($ownerTransformer, $noticeTransformer, $installedAppUiTransformer, $installedAppIconImageTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getIconImage());
        self::assertNull($transformer->transform($base + [InstalledAppDetailsTransformerInterface::KEY_ICON_IMAGE => 'test-not-array'])->getIconImage());
        self::assertSame($installedAppIconImageModel, $transformer->transform($base + [InstalledAppDetailsTransformerInterface::KEY_ICON_IMAGE => ['test-nested']])->getIconImage());
    }

    public function testTransformNotices(): void
    {
        $ownerModel = self::createStub(OwnerInterface::class);
        $ownerTransformer = self::createStub(OwnerTransformerInterface::class);
        $ownerTransformer->method('transform')->willReturn($ownerModel);
        $noticeModel = self::createStub(NoticeInterface::class);
        $noticeTransformer = self::createStub(NoticeTransformerInterface::class);
        $noticeTransformer->method('transform')->willReturn($noticeModel);
        $installedAppUiModel = self::createStub(InstalledAppUiInterface::class);
        $installedAppUiTransformer = self::createStub(InstalledAppUiTransformerInterface::class);
        $installedAppUiTransformer->method('transform')->willReturn($installedAppUiModel);
        $installedAppIconImageModel = self::createStub(InstalledAppIconImageInterface::class);
        $installedAppIconImageTransformer = self::createStub(InstalledAppIconImageTransformerInterface::class);
        $installedAppIconImageTransformer->method('transform')->willReturn($installedAppIconImageModel);
        $transformer = new InstalledAppDetailsTransformer($ownerTransformer, $noticeTransformer, $installedAppUiTransformer, $installedAppIconImageTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getNotices());
        self::assertNull($transformer->transform($base + [InstalledAppDetailsTransformerInterface::KEY_NOTICES => 'test-not-array'])->getNotices());
        self::assertSame([$noticeModel], $transformer->transform($base + [InstalledAppDetailsTransformerInterface::KEY_NOTICES => [['test-nested'], 'test-skipped']])->getNotices());
    }

    public function testTransformOwner(): void
    {
        $ownerModel = self::createStub(OwnerInterface::class);
        $ownerTransformer = self::createStub(OwnerTransformerInterface::class);
        $ownerTransformer->method('transform')->willReturn($ownerModel);
        $noticeModel = self::createStub(NoticeInterface::class);
        $noticeTransformer = self::createStub(NoticeTransformerInterface::class);
        $noticeTransformer->method('transform')->willReturn($noticeModel);
        $installedAppUiModel = self::createStub(InstalledAppUiInterface::class);
        $installedAppUiTransformer = self::createStub(InstalledAppUiTransformerInterface::class);
        $installedAppUiTransformer->method('transform')->willReturn($installedAppUiModel);
        $installedAppIconImageModel = self::createStub(InstalledAppIconImageInterface::class);
        $installedAppIconImageTransformer = self::createStub(InstalledAppIconImageTransformerInterface::class);
        $installedAppIconImageTransformer->method('transform')->willReturn($installedAppIconImageModel);
        $transformer = new InstalledAppDetailsTransformer($ownerTransformer, $noticeTransformer, $installedAppUiTransformer, $installedAppIconImageTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getOwner());
        self::assertNull($transformer->transform($base + [InstalledAppDetailsTransformerInterface::KEY_OWNER => 'test-not-array'])->getOwner());
        self::assertSame($ownerModel, $transformer->transform($base + [InstalledAppDetailsTransformerInterface::KEY_OWNER => ['test-nested']])->getOwner());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $ownerModel = self::createStub(OwnerInterface::class);
        $ownerTransformer = self::createStub(OwnerTransformerInterface::class);
        $ownerTransformer->method('transform')->willReturn($ownerModel);
        $noticeModel = self::createStub(NoticeInterface::class);
        $noticeTransformer = self::createStub(NoticeTransformerInterface::class);
        $noticeTransformer->method('transform')->willReturn($noticeModel);
        $installedAppUiModel = self::createStub(InstalledAppUiInterface::class);
        $installedAppUiTransformer = self::createStub(InstalledAppUiTransformerInterface::class);
        $installedAppUiTransformer->method('transform')->willReturn($installedAppUiModel);
        $installedAppIconImageModel = self::createStub(InstalledAppIconImageInterface::class);
        $installedAppIconImageTransformer = self::createStub(InstalledAppIconImageTransformerInterface::class);
        $installedAppIconImageTransformer->method('transform')->willReturn($installedAppIconImageModel);
        $transformer = new InstalledAppDetailsTransformer($ownerTransformer, $noticeTransformer, $installedAppUiTransformer, $installedAppIconImageTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getOwner());
        self::assertNull($actual->getNotices());
        self::assertNull($actual->getUi());
        self::assertNull($actual->getIconImage());
    }

    public function testTransformUi(): void
    {
        $ownerModel = self::createStub(OwnerInterface::class);
        $ownerTransformer = self::createStub(OwnerTransformerInterface::class);
        $ownerTransformer->method('transform')->willReturn($ownerModel);
        $noticeModel = self::createStub(NoticeInterface::class);
        $noticeTransformer = self::createStub(NoticeTransformerInterface::class);
        $noticeTransformer->method('transform')->willReturn($noticeModel);
        $installedAppUiModel = self::createStub(InstalledAppUiInterface::class);
        $installedAppUiTransformer = self::createStub(InstalledAppUiTransformerInterface::class);
        $installedAppUiTransformer->method('transform')->willReturn($installedAppUiModel);
        $installedAppIconImageModel = self::createStub(InstalledAppIconImageInterface::class);
        $installedAppIconImageTransformer = self::createStub(InstalledAppIconImageTransformerInterface::class);
        $installedAppIconImageTransformer->method('transform')->willReturn($installedAppIconImageModel);
        $transformer = new InstalledAppDetailsTransformer($ownerTransformer, $noticeTransformer, $installedAppUiTransformer, $installedAppIconImageTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getUi());
        self::assertNull($transformer->transform($base + [InstalledAppDetailsTransformerInterface::KEY_UI => 'test-not-array'])->getUi());
        self::assertSame($installedAppUiModel, $transformer->transform($base + [InstalledAppDetailsTransformerInterface::KEY_UI => ['test-nested']])->getUi());
    }
}
