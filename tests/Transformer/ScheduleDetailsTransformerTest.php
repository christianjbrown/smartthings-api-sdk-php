<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\CronScheduleInterface;
use ChristianBrown\SmartThings\Model\ScheduleDetails;
use ChristianBrown\SmartThings\Transformer\CronScheduleTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ScheduleDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\ScheduleDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ScheduleDetails::class)]
#[CoversClass(ScheduleDetailsTransformer::class)]
final class ScheduleDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $cronScheduleModel = self::createStub(CronScheduleInterface::class);
        $cronScheduleTransformer = self::createStub(CronScheduleTransformerInterface::class);
        $cronScheduleTransformer->method('transform')->willReturn($cronScheduleModel);
        $data = [
            ScheduleDetailsTransformerInterface::KEY_CRON => ['test-nested'],
        ];

        $transformer = new ScheduleDetailsTransformer($cronScheduleTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($cronScheduleModel, $actual->getCron());
    }

    public function testTransformCron(): void
    {
        $cronScheduleModel = self::createStub(CronScheduleInterface::class);
        $cronScheduleTransformer = self::createStub(CronScheduleTransformerInterface::class);
        $cronScheduleTransformer->method('transform')->willReturn($cronScheduleModel);
        $transformer = new ScheduleDetailsTransformer($cronScheduleTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getCron());
        self::assertNull($transformer->transform($base + [ScheduleDetailsTransformerInterface::KEY_CRON => 'test-not-array'])->getCron());
        self::assertSame($cronScheduleModel, $transformer->transform($base + [ScheduleDetailsTransformerInterface::KEY_CRON => ['test-nested']])->getCron());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $cronScheduleModel = self::createStub(CronScheduleInterface::class);
        $cronScheduleTransformer = self::createStub(CronScheduleTransformerInterface::class);
        $cronScheduleTransformer->method('transform')->willReturn($cronScheduleModel);
        $transformer = new ScheduleDetailsTransformer($cronScheduleTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getCron());
    }
}
