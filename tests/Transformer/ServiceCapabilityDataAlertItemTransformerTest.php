<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ServiceCapabilityDataAlertItem;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataAlertItemLastUpdateTimeInterface;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataAlertItemSeverityInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataAlertItemSeverityTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataAlertItemTransformer;
use ChristianBrown\SmartThings\Transformer\ServiceCapabilityDataAlertItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ServiceCapabilityDataAlertItem::class)]
#[CoversClass(ServiceCapabilityDataAlertItemTransformer::class)]
final class ServiceCapabilityDataAlertItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $serviceCapabilityDataAlertItemLastUpdateTimeModel = self::createStub(ServiceCapabilityDataAlertItemLastUpdateTimeInterface::class);
        $serviceCapabilityDataAlertItemLastUpdateTimeTransformer = self::createStub(ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface::class);
        $serviceCapabilityDataAlertItemLastUpdateTimeTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemLastUpdateTimeModel);
        $serviceCapabilityDataAlertItemSeverityModel = self::createStub(ServiceCapabilityDataAlertItemSeverityInterface::class);
        $serviceCapabilityDataAlertItemSeverityTransformer = self::createStub(ServiceCapabilityDataAlertItemSeverityTransformerInterface::class);
        $serviceCapabilityDataAlertItemSeverityTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemSeverityModel);
        $data = [
            ServiceCapabilityDataAlertItemTransformerInterface::KEY_LAST_UPDATE_TIME => ['test-nested'],
            ServiceCapabilityDataAlertItemTransformerInterface::KEY_HEADLINE_TEXT => ['test-nested'],
            ServiceCapabilityDataAlertItemTransformerInterface::KEY_SEVERITY => ['test-nested'],
            ServiceCapabilityDataAlertItemTransformerInterface::KEY_MESSAGE_TYPE => ['test-nested'],
            ServiceCapabilityDataAlertItemTransformerInterface::KEY_ISSUE_TIME => ['test-nested'],
            ServiceCapabilityDataAlertItemTransformerInterface::KEY_EXPIRE_TIME => ['test-nested'],
        ];

        $transformer = new ServiceCapabilityDataAlertItemTransformer($serviceCapabilityDataAlertItemLastUpdateTimeTransformer, $serviceCapabilityDataAlertItemSeverityTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($serviceCapabilityDataAlertItemLastUpdateTimeModel, $actual->getLastUpdateTime());
        self::assertSame($serviceCapabilityDataAlertItemLastUpdateTimeModel, $actual->getHeadlineText());
        self::assertSame($serviceCapabilityDataAlertItemSeverityModel, $actual->getSeverity());
        self::assertSame($serviceCapabilityDataAlertItemSeverityModel, $actual->getMessageType());
        self::assertSame($serviceCapabilityDataAlertItemLastUpdateTimeModel, $actual->getIssueTime());
        self::assertSame($serviceCapabilityDataAlertItemLastUpdateTimeModel, $actual->getExpireTime());
    }

    public function testTransformExpireTime(): void
    {
        $serviceCapabilityDataAlertItemLastUpdateTimeModel = self::createStub(ServiceCapabilityDataAlertItemLastUpdateTimeInterface::class);
        $serviceCapabilityDataAlertItemLastUpdateTimeTransformer = self::createStub(ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface::class);
        $serviceCapabilityDataAlertItemLastUpdateTimeTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemLastUpdateTimeModel);
        $serviceCapabilityDataAlertItemSeverityModel = self::createStub(ServiceCapabilityDataAlertItemSeverityInterface::class);
        $serviceCapabilityDataAlertItemSeverityTransformer = self::createStub(ServiceCapabilityDataAlertItemSeverityTransformerInterface::class);
        $serviceCapabilityDataAlertItemSeverityTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemSeverityModel);
        $transformer = new ServiceCapabilityDataAlertItemTransformer($serviceCapabilityDataAlertItemLastUpdateTimeTransformer, $serviceCapabilityDataAlertItemSeverityTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getExpireTime());
        self::assertNull($transformer->transform($base + [ServiceCapabilityDataAlertItemTransformerInterface::KEY_EXPIRE_TIME => 'test-not-array'])->getExpireTime());
        self::assertSame($serviceCapabilityDataAlertItemLastUpdateTimeModel, $transformer->transform($base + [ServiceCapabilityDataAlertItemTransformerInterface::KEY_EXPIRE_TIME => ['test-nested']])->getExpireTime());
    }

    public function testTransformHeadlineText(): void
    {
        $serviceCapabilityDataAlertItemLastUpdateTimeModel = self::createStub(ServiceCapabilityDataAlertItemLastUpdateTimeInterface::class);
        $serviceCapabilityDataAlertItemLastUpdateTimeTransformer = self::createStub(ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface::class);
        $serviceCapabilityDataAlertItemLastUpdateTimeTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemLastUpdateTimeModel);
        $serviceCapabilityDataAlertItemSeverityModel = self::createStub(ServiceCapabilityDataAlertItemSeverityInterface::class);
        $serviceCapabilityDataAlertItemSeverityTransformer = self::createStub(ServiceCapabilityDataAlertItemSeverityTransformerInterface::class);
        $serviceCapabilityDataAlertItemSeverityTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemSeverityModel);
        $transformer = new ServiceCapabilityDataAlertItemTransformer($serviceCapabilityDataAlertItemLastUpdateTimeTransformer, $serviceCapabilityDataAlertItemSeverityTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getHeadlineText());
        self::assertNull($transformer->transform($base + [ServiceCapabilityDataAlertItemTransformerInterface::KEY_HEADLINE_TEXT => 'test-not-array'])->getHeadlineText());
        self::assertSame($serviceCapabilityDataAlertItemLastUpdateTimeModel, $transformer->transform($base + [ServiceCapabilityDataAlertItemTransformerInterface::KEY_HEADLINE_TEXT => ['test-nested']])->getHeadlineText());
    }

    public function testTransformIssueTime(): void
    {
        $serviceCapabilityDataAlertItemLastUpdateTimeModel = self::createStub(ServiceCapabilityDataAlertItemLastUpdateTimeInterface::class);
        $serviceCapabilityDataAlertItemLastUpdateTimeTransformer = self::createStub(ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface::class);
        $serviceCapabilityDataAlertItemLastUpdateTimeTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemLastUpdateTimeModel);
        $serviceCapabilityDataAlertItemSeverityModel = self::createStub(ServiceCapabilityDataAlertItemSeverityInterface::class);
        $serviceCapabilityDataAlertItemSeverityTransformer = self::createStub(ServiceCapabilityDataAlertItemSeverityTransformerInterface::class);
        $serviceCapabilityDataAlertItemSeverityTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemSeverityModel);
        $transformer = new ServiceCapabilityDataAlertItemTransformer($serviceCapabilityDataAlertItemLastUpdateTimeTransformer, $serviceCapabilityDataAlertItemSeverityTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getIssueTime());
        self::assertNull($transformer->transform($base + [ServiceCapabilityDataAlertItemTransformerInterface::KEY_ISSUE_TIME => 'test-not-array'])->getIssueTime());
        self::assertSame($serviceCapabilityDataAlertItemLastUpdateTimeModel, $transformer->transform($base + [ServiceCapabilityDataAlertItemTransformerInterface::KEY_ISSUE_TIME => ['test-nested']])->getIssueTime());
    }

    public function testTransformLastUpdateTime(): void
    {
        $serviceCapabilityDataAlertItemLastUpdateTimeModel = self::createStub(ServiceCapabilityDataAlertItemLastUpdateTimeInterface::class);
        $serviceCapabilityDataAlertItemLastUpdateTimeTransformer = self::createStub(ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface::class);
        $serviceCapabilityDataAlertItemLastUpdateTimeTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemLastUpdateTimeModel);
        $serviceCapabilityDataAlertItemSeverityModel = self::createStub(ServiceCapabilityDataAlertItemSeverityInterface::class);
        $serviceCapabilityDataAlertItemSeverityTransformer = self::createStub(ServiceCapabilityDataAlertItemSeverityTransformerInterface::class);
        $serviceCapabilityDataAlertItemSeverityTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemSeverityModel);
        $transformer = new ServiceCapabilityDataAlertItemTransformer($serviceCapabilityDataAlertItemLastUpdateTimeTransformer, $serviceCapabilityDataAlertItemSeverityTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getLastUpdateTime());
        self::assertNull($transformer->transform($base + [ServiceCapabilityDataAlertItemTransformerInterface::KEY_LAST_UPDATE_TIME => 'test-not-array'])->getLastUpdateTime());
        self::assertSame($serviceCapabilityDataAlertItemLastUpdateTimeModel, $transformer->transform($base + [ServiceCapabilityDataAlertItemTransformerInterface::KEY_LAST_UPDATE_TIME => ['test-nested']])->getLastUpdateTime());
    }

    public function testTransformMessageType(): void
    {
        $serviceCapabilityDataAlertItemLastUpdateTimeModel = self::createStub(ServiceCapabilityDataAlertItemLastUpdateTimeInterface::class);
        $serviceCapabilityDataAlertItemLastUpdateTimeTransformer = self::createStub(ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface::class);
        $serviceCapabilityDataAlertItemLastUpdateTimeTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemLastUpdateTimeModel);
        $serviceCapabilityDataAlertItemSeverityModel = self::createStub(ServiceCapabilityDataAlertItemSeverityInterface::class);
        $serviceCapabilityDataAlertItemSeverityTransformer = self::createStub(ServiceCapabilityDataAlertItemSeverityTransformerInterface::class);
        $serviceCapabilityDataAlertItemSeverityTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemSeverityModel);
        $transformer = new ServiceCapabilityDataAlertItemTransformer($serviceCapabilityDataAlertItemLastUpdateTimeTransformer, $serviceCapabilityDataAlertItemSeverityTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getMessageType());
        self::assertNull($transformer->transform($base + [ServiceCapabilityDataAlertItemTransformerInterface::KEY_MESSAGE_TYPE => 'test-not-array'])->getMessageType());
        self::assertSame($serviceCapabilityDataAlertItemSeverityModel, $transformer->transform($base + [ServiceCapabilityDataAlertItemTransformerInterface::KEY_MESSAGE_TYPE => ['test-nested']])->getMessageType());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $serviceCapabilityDataAlertItemLastUpdateTimeModel = self::createStub(ServiceCapabilityDataAlertItemLastUpdateTimeInterface::class);
        $serviceCapabilityDataAlertItemLastUpdateTimeTransformer = self::createStub(ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface::class);
        $serviceCapabilityDataAlertItemLastUpdateTimeTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemLastUpdateTimeModel);
        $serviceCapabilityDataAlertItemSeverityModel = self::createStub(ServiceCapabilityDataAlertItemSeverityInterface::class);
        $serviceCapabilityDataAlertItemSeverityTransformer = self::createStub(ServiceCapabilityDataAlertItemSeverityTransformerInterface::class);
        $serviceCapabilityDataAlertItemSeverityTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemSeverityModel);
        $transformer = new ServiceCapabilityDataAlertItemTransformer($serviceCapabilityDataAlertItemLastUpdateTimeTransformer, $serviceCapabilityDataAlertItemSeverityTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getLastUpdateTime());
        self::assertNull($actual->getHeadlineText());
        self::assertNull($actual->getSeverity());
        self::assertNull($actual->getMessageType());
        self::assertNull($actual->getIssueTime());
        self::assertNull($actual->getExpireTime());
    }

    public function testTransformSeverity(): void
    {
        $serviceCapabilityDataAlertItemLastUpdateTimeModel = self::createStub(ServiceCapabilityDataAlertItemLastUpdateTimeInterface::class);
        $serviceCapabilityDataAlertItemLastUpdateTimeTransformer = self::createStub(ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface::class);
        $serviceCapabilityDataAlertItemLastUpdateTimeTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemLastUpdateTimeModel);
        $serviceCapabilityDataAlertItemSeverityModel = self::createStub(ServiceCapabilityDataAlertItemSeverityInterface::class);
        $serviceCapabilityDataAlertItemSeverityTransformer = self::createStub(ServiceCapabilityDataAlertItemSeverityTransformerInterface::class);
        $serviceCapabilityDataAlertItemSeverityTransformer->method('transform')->willReturn($serviceCapabilityDataAlertItemSeverityModel);
        $transformer = new ServiceCapabilityDataAlertItemTransformer($serviceCapabilityDataAlertItemLastUpdateTimeTransformer, $serviceCapabilityDataAlertItemSeverityTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getSeverity());
        self::assertNull($transformer->transform($base + [ServiceCapabilityDataAlertItemTransformerInterface::KEY_SEVERITY => 'test-not-array'])->getSeverity());
        self::assertSame($serviceCapabilityDataAlertItemSeverityModel, $transformer->transform($base + [ServiceCapabilityDataAlertItemTransformerInterface::KEY_SEVERITY => ['test-nested']])->getSeverity());
    }
}
